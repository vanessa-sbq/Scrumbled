DROP SCHEMA IF EXISTS lbaw24113 CASCADE;
CREATE SCHEMA lbaw24113;
SET search_path TO lbaw24113;

DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS authenticated_user;
DROP TABLE IF EXISTS product_owner;
DROP TABLE IF EXISTS developer;
DROP TABLE IF EXISTS scrum_master;
DROP TABLE IF EXISTS project;
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS developer_project;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS task;
DROP TABLE IF EXISTS sprint;
DROP TYPE IF EXISTS value_level;
DROP TYPE IF EXISTS task_state;
DROP TYPE IF EXISTS account_status;

-- Relation: admin
CREATE TABLE
    admin (
        id BIGSERIAL PRIMARY KEY,
        hashed_password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: authenticated_user

CREATE TYPE account_status AS ENUM (
    'NEEDS_CONFIRMATION',
    'ACTIVE',
    'BANNED'
);

CREATE TABLE
    authenticated_user (
        id BIGSERIAL PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        hashed_password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        bio TEXT,
        picture TEXT,
        status account_status NOT NULL DEFAULT 'NEEDS_CONFIRMATION',
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: product_owner
CREATE TABLE
    product_owner (
        user_id BIGINT PRIMARY KEY REFERENCES authenticated_user (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Relation: developer
CREATE TABLE
    developer (
        user_id BIGINT PRIMARY KEY REFERENCES authenticated_user (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Relation: scrum_master
CREATE TABLE
    scrum_master (
        developer_id BIGINT PRIMARY KEY REFERENCES developer (user_id) ON DELETE CASCADE ON UPDATE CASCADE
    );

-- Relation: project
CREATE TABLE
    project (
        id BIGSERIAL PRIMARY KEY,
        slug VARCHAR(255) NOT NULL UNIQUE,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        product_owner_id BIGINT REFERENCES product_owner (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
        scrum_master_id BIGINT REFERENCES scrum_master (developer_id) ON DELETE SET NULL ON UPDATE CASCADE,
        is_public BOOLEAN NOT NULL DEFAULT FALSE,
        is_archived BOOLEAN NOT NULL DEFAULT FALSE,
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: favorite
CREATE TABLE
    favorite (
        user_id BIGINT NOT NULL REFERENCES authenticated_user (id) ON DELETE CASCADE ON UPDATE CASCADE,
        project_id BIGINT NOT NULL REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        PRIMARY KEY (user_id, project_id)
    );

-- Relation: developer_project
CREATE TABLE
    developer_project (
        developer_id BIGINT NOT NULL REFERENCES developer (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
        project_id BIGINT NOT NULL REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        is_pending BOOLEAN NOT NULL DEFAULT TRUE,
        PRIMARY KEY (developer_id, project_id)
    );

-- Relation: sprint
CREATE TABLE
    sprint (
        id BIGSERIAL PRIMARY KEY,
        project_id BIGINT NOT NULL REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        name VARCHAR(255),
        start_date TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
        end_date TIMESTAMPTZ CHECK (end_date > start_date)
    );

-- Type: value_level
CREATE TYPE value_level AS ENUM (
    'MUST_HAVE',
    'SHOULD_HAVE',
    'COULD_HAVE',
    'WILL_NOT_HAVE'
);

CREATE TYPE task_state AS ENUM (
    'BACKLOG',
    'SPRINT_BACKLOG',
    'IN_PROGRESS',
    'DONE',
    'ACCEPTED'
);

-- Relation: task
CREATE TABLE
    task (
        id BIGSERIAL PRIMARY KEY,
        project_id BIGINT NOT NULL REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        sprint_id BIGINT REFERENCES sprint (id) ON DELETE SET NULL ON UPDATE CASCADE,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        assigned_to INT REFERENCES developer (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
        value value_level,
        state task_state NOT NULL DEFAULT 'BACKLOG',
        effort INT CHECK (effort IN (1, 2, 3, 5, 8, 13)),
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: comment
CREATE TABLE
    comment (
        id BIGSERIAL PRIMARY KEY,
        task_id BIGINT NOT NULL REFERENCES task (id) ON DELETE CASCADE ON UPDATE CASCADE,
        user_id BIGINT REFERENCES authenticated_user (id) ON DELETE SET NULL ON UPDATE CASCADE,
        description TEXT NOT NULL,
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

CREATE TYPE notification_type AS ENUM (
    'COMPLETED_TASK',
    'INVITE',
    'ACCEPTED_INVITATION',
    'ASSIGN',
    'PO_CHANGE'
);

CREATE TABLE
    notification (
        id BIGSERIAL PRIMARY KEY,
        receiver_id BIGINT NOT NULL REFERENCES authenticated_user (id) ON DELETE CASCADE ON UPDATE CASCADE, -- receiver
        type notification_type NOT NULL,
        project_id BIGINT REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        old_product_owner_id BIGINT REFERENCES product_owner (user_id) ON DELETE SET NULL ON UPDATE CASCADE, -- old product owner
        new_product_owner_id BIGINT REFERENCES product_owner (user_id) ON UPDATE CASCADE, -- new product owner
        task_id BIGINT REFERENCES task (id) ON DELETE CASCADE ON UPDATE CASCADE,
        invited_user_id BIGINT REFERENCES authenticated_user (id) ON DELETE CASCADE ON UPDATE CASCADE,
        completed_by BIGINT REFERENCES developer (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

CREATE INDEX IDX01 ON notification USING HASH (receiver_id);

CREATE INDEX IDX02 ON comment USING BTREE (task_id);

CREATE INDEX IDX03 ON task USING BTREE (project_id);

-- Add column to project to store computed ts_vectors.
ALTER TABLE project
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION project_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on project.
CREATE TRIGGER project_search_update
 BEFORE INSERT OR UPDATE ON project
 FOR EACH ROW
 EXECUTE PROCEDURE project_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX project_search_idx ON project USING GIN (tsvectors);

-- Add column to authenticated_user to store computed ts_vectors.
ALTER TABLE authenticated_user ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION authenticated_user_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.username), 'A') ||
         setweight(to_tsvector('english', NEW.full_name), 'B') ||
         setweight(to_tsvector('english', NEW.bio), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF ((NEW.username <> OLD.username) || (NEW.full_name <> OLD.full_name) || (NEW.bio <> OLD.bio)) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.username), 'A') ||
             setweight(to_tsvector('english', NEW.full_name), 'B') ||
             setweight(to_tsvector('english', NEW.bio), 'C')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on authenticated_user.
CREATE TRIGGER authenticated_user_search_update
 BEFORE INSERT OR UPDATE ON authenticated_user
 FOR EACH ROW
 EXECUTE PROCEDURE authenticated_user_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX auth_user_search_idx ON authenticated_user USING GIN (tsvectors);

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

CREATE TRIGGER po_change_notification_trigger
    AFTER UPDATE OF product_owner_id ON Project
    FOR EACH ROW
    WHEN (OLD.product_owner_id IS DISTINCT FROM NEW.product_owner_id)
    EXECUTE PROCEDURE create_po_change_notification();

DROP TRIGGER IF EXISTS before_user_delete ON authenticated_user;
DROP FUNCTION IF EXISTS check_user_deletion();

CREATE OR REPLACE FUNCTION check_user_deletion() 
RETURNS TRIGGER AS $BODY$
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
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER before_user_delete
BEFORE DELETE ON authenticated_user
FOR EACH ROW
EXECUTE PROCEDURE check_user_deletion();

DROP TRIGGER IF EXISTS developer_update_task ON task;
DROP FUNCTION IF EXISTS create_completed_task_notification();

CREATE FUNCTION create_completed_task_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    user_id BIGINT;
BEGIN
        IF NEW.state = 'ACCEPTED'::task_state THEN
                FOR user_id IN
                        SELECT product_owner_id as user_id FROM lbaw24113.project
                        UNION
                        SELECT developer_id as user_id FROM project JOIN developer_project ON project.id = developer_project.project_id
                LOOP
                        INSERT INTO notification (receiver_id, type, task_id, completed_by, created_at) VALUES (user_id, 'COMPLETED_TASK', NEW.id, NEW.assigned_to, now());
                END LOOP;
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER developer_update_task
        BEFORE UPDATE ON task
        FOR EACH ROW
        EXECUTE PROCEDURE create_completed_task_notification();

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

-- Trigger to handle the response to an invitation
CREATE TRIGGER handle_invite_response_trigger
AFTER UPDATE OF is_pending
ON developer_project
FOR EACH ROW
WHEN (NEW.is_pending = false)
EXECUTE FUNCTION handle_invite_response();

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
        NEW.developer_id,
        NOW()
    );

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_create_invite_notification
    AFTER INSERT ON developer_project
    FOR EACH ROW
    EXECUTE FUNCTION create_pending_notification();

CREATE OR REPLACE FUNCTION create_assign_notification() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notification (receiver_id, type, task_id)
    VALUES (NEW.assigned_to, 'ASSIGN', NEW.id);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER assign_notification_trigger
    AFTER UPDATE OF assigned_to ON task
    FOR EACH ROW
    WHEN (OLD.assigned_to IS DISTINCT FROM NEW.assigned_to) 
    EXECUTE PROCEDURE create_assign_notification();

