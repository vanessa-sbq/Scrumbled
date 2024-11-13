-----------------------------------------
-- TRIGGER 01
-----------------------------------------

-- Create a function to create a notification when the product owner changes.
CREATE OR REPLACE FUNCTION create_po_change_notification() RETURNS TRIGGER AS $$
DECLARE
    dev_id BIGINT;
BEGIN
    -- Loop through each developer of the project and send a notification
    FOR dev_id IN
        SELECT developer_id
        FROM developer_project
        WHERE project_id = NEW.id AND is_pending = FALSE
    LOOP
        INSERT INTO notification (receiver_id, type, project_id, old_product_owner_id, new_product_owner_id)
        VALUES (dev_id, 'PO_CHANGE', NEW.id, OLD.product_owner_id, NEW.product_owner_id);
    END LOOP;

    -- Send a notification to the new product owner 
    IF NEW.product_owner_id IS DISTINCT FROM OLD.product_owner_id THEN
        INSERT INTO notification (receiver_id, type, project_id, old_product_owner_id, new_product_owner_id)
        VALUES (NEW.product_owner_id, 'PO_CHANGE', NEW.id, OLD.product_owner_id, NEW.product_owner_id);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to notify team members when the product owner changes.
CREATE TRIGGER po_change_notification_trigger
    AFTER UPDATE OF product_owner_id ON project
    FOR EACH ROW
    WHEN (OLD.product_owner_id IS DISTINCT FROM NEW.product_owner_id)
    EXECUTE PROCEDURE create_po_change_notification();

-----------------------------------------
-- TRIGGER 02
-----------------------------------------

-- Create a function to check if the user can be deleted.
CREATE OR REPLACE FUNCTION check_user_deletion() 
RETURNS TRIGGER AS $$
BEGIN
    IF NOT EXISTS (
        SELECT project.id 
        FROM authenticated_user 
        JOIN project ON authenticated_user.id = project.product_owner_id 
        WHERE authenticated_user.id = OLD.id 
        AND project.is_archived = false
    ) THEN
        RETURN OLD;
    ELSE
        RAISE EXCEPTION 'Cannot delete user with active projects';
    END IF;
END
$$ LANGUAGE plpgsql;

-- Create a trigger to check user deletion.
CREATE TRIGGER before_user_delete
BEFORE DELETE ON authenticated_user
FOR EACH ROW
EXECUTE PROCEDURE check_user_deletion();

-----------------------------------------
-- TRIGGER 03
-----------------------------------------

-- Create a function to notify team members when a task is accepted.
CREATE FUNCTION create_completed_task_notification() RETURNS TRIGGER AS $$
DECLARE
    user_id BIGINT;
BEGIN
    IF NEW.state = 'ACCEPTED'::task_state THEN
        FOR user_id IN
            SELECT product_owner_id as user_id FROM project
            UNION
            SELECT developer_id as user_id FROM project JOIN developer_project ON project.id = developer_project.project_id
        LOOP
            INSERT INTO notification (receiver_id, type, task_id, completed_by, created_at) 
            VALUES (user_id, 'COMPLETED_TASK', NEW.id, NEW.assigned_to, now());
        END LOOP;
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;

-- Create a trigger to notify team members when a task is accepted.
CREATE TRIGGER developer_update_task
    BEFORE UPDATE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE create_completed_task_notification();

-----------------------------------------
-- TRIGGER 04
-----------------------------------------

-- Create a function to handle the response to an invitation.
CREATE OR REPLACE FUNCTION handle_invite_response()
RETURNS TRIGGER AS $$
BEGIN
    -- Delete the invite notification
    DELETE FROM notification
    WHERE receiver_id = NEW.developer_id AND project_id = NEW.project_id AND type = 'INVITE';

    -- Send notification to the project owner
    INSERT INTO notification (receiver_id, type, project_id, invited_user_id, created_at)
    VALUES ((SELECT product_owner_id FROM project WHERE id = NEW.project_id), 'ACCEPTED_INVITATION', NEW.project_id, NEW.developer_id, NOW());

    -- Send notification to the scrum master
    INSERT INTO notification (receiver_id, type, project_id, invited_user_id, created_at)
    VALUES ((SELECT scrum_master_id FROM project WHERE id = NEW.project_id), 'ACCEPTED_INVITATION', NEW.project_id, NEW.developer_id, NOW());

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to handle the response to an invitation.
CREATE TRIGGER handle_invite_response_trigger
    AFTER UPDATE OF is_pending
    ON developer_project
    FOR EACH ROW
    WHEN (NEW.is_pending = false)
    EXECUTE FUNCTION handle_invite_response();

-----------------------------------------
-- TRIGGER 05
-----------------------------------------

-- Create a function to create a notification when a new developer is added to a project.
CREATE OR REPLACE FUNCTION create_pending_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notification (
        receiver_id,
        type,
        project_id,
        invited_user_id,
        created_at
    )
    VALUES (
        NEW.developer_id,
        'INVITE',
        NEW.project_id,
        NEW.developer_id, -- Corrected field
        NOW()
    );

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to notify when a new developer is added to a project.
CREATE TRIGGER trigger_create_invite_notification
AFTER INSERT ON developer_project
FOR EACH ROW
EXECUTE FUNCTION create_pending_notification();

-----------------------------------------
-- TRIGGER 06
-----------------------------------------

-- Create a function to create a notification when a developer is assigned to a task.
CREATE OR REPLACE FUNCTION create_assign_notification() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notification (receiver_id, type, task_id)
    VALUES (NEW.assigned_to, 'ASSIGN', NEW.id);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to notify when a developer is assigned to a task.
CREATE TRIGGER assign_notification_trigger
    AFTER UPDATE OF assigned_to ON task
    FOR EACH ROW
    WHEN (OLD.assigned_to IS DISTINCT FROM NEW.assigned_to) 
    EXECUTE PROCEDURE create_assign_notification();

-----------------------------------------
-- TRIGGER 07
-----------------------------------------

-- Create a function to ensure the user is added to the appropriate role tables before creating a project.
CREATE OR REPLACE FUNCTION ensure_roles_before_project_insert() RETURNS TRIGGER AS $$
BEGIN
    -- Ensure the product owner is in the product_owner table
    IF NEW.product_owner_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM product_owner WHERE user_id = NEW.product_owner_id) THEN
        INSERT INTO product_owner (user_id) VALUES (NEW.product_owner_id);
    END IF;

    -- Ensure the scrum master is in the developer and scrum_master tables
    IF NEW.scrum_master_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM developer WHERE user_id = NEW.scrum_master_id) THEN
        INSERT INTO developer (user_id) VALUES (NEW.scrum_master_id);
    END IF;

    IF NEW.scrum_master_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM scrum_master WHERE developer_id = NEW.scrum_master_id) THEN
        INSERT INTO scrum_master (developer_id) VALUES (NEW.scrum_master_id);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to call the function before inserting a project.
CREATE TRIGGER before_project_insert
BEFORE INSERT ON project
FOR EACH ROW
EXECUTE FUNCTION ensure_roles_before_project_insert();