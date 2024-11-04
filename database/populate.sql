-- POPULATE

-- Populate authenticated_user table
INSERT INTO authenticated_user (id, username, hashed_password, full_name, email, bio, picture, status)
VALUES
(1, 'antonio', 'hashed_password1', 'Antonio Abilio', 'up202205469@up.pt', 'Hi!', 'picture1.png', 'ACTIVE'),
(2, 'vanessa', 'hashed_password2', 'Vanessa Queiros', 'up202207919@up.pt', 'Hi!', 'picture2.png', 'ACTIVE'),
(3, 'joao', 'hashed_password3', 'Joao Santos', 'up202205794@up.pt', 'Hi!', 'picture3.png', 'ACTIVE'),
(4, 'simao', 'hashed_password4', 'Simao Neri', 'up202206370@up.pt', 'Hi!', 'picture4.png', 'ACTIVE');

-- Populate product_owner table
INSERT INTO product_owner (user_id)
VALUES
(1),
(2);

-- Populate developer table
INSERT INTO developer (user_id)
VALUES
(3),
(4);

-- Populate scrum_master table
INSERT INTO scrum_master (developer_id)
VALUES
(3);

-- Populate project table
INSERT INTO project (id, slug, title, description, product_owner_id, scrum_master_id, is_public)
VALUES
(1, 'scrumbled', 'Scrumbled', 'Lbaw project', 1, 3, TRUE),
(2, 'jira', 'Jira', 'Copy of Scrumbled', 2, 3, FALSE);

-- Populate favorite table
INSERT INTO favorite (user_id, project_id)
VALUES
(1, 1),
(3, 2);

-- Populate developer_project table
INSERT INTO developer_project (developer_id, project_id, is_pending)
VALUES
(3, 1, FALSE),
(3, 2, FALSE),
(4, 2, FALSE),
(4, 1, TRUE);


-- Populate sprint table
INSERT INTO sprint (id, project_id, name, start_date, end_date)
VALUES
(1, 1, 'Scrumbled Big Bang', NOW(), NOW() + INTERVAL '1 month'),
(2, 2, 'Sprint #1', NOW(), NOW() + INTERVAL '1 month');

-- Populate task table
INSERT INTO task (id, project_id, sprint_id, title, description, assigned_to, value, state, effort)
VALUES
(1, 1, 1, 'Login', 'User Login.', 3, 'MUST_HAVE', 'SPRINT_BACKLOG', 8),
(2, 2, 2, 'Migrate all users', 'Migrate all users from Jira to Scrumbled.', 4, 'MUST_HAVE', 'IN_PROGRESS', 13),
(3, 2, NULL, 'Delete Database', 'Delete Database after migration.', NULL, 'MUST_HAVE', 'BACKLOG', 13),
(4, 1, 1, 'Be better than Jira', 'Title says it all.', 3, 'MUST_HAVE', 'ACCEPTED', 13);

-- Populate comment table
INSERT INTO comment (task_id, user_id, description)
VALUES
(1, 1, 'We can use Jira SSO instead.'),
(2, 2, 'This needs to be done as soon as possible! Our product is irrelevant now.');

-- Populate the notification table with an invitation notification
-- User Simão (ID 4) is invited to project ID 1 (Scrumbled Project)
INSERT INTO notification (receiver_id, type, project_id)
VALUES
(4, 'INVITE', 1);

-- Populate the notification table with an accepted invitation notification
-- User João (ID 3) accepted an invitation to project ID 1 (Scrumbled Project)
INSERT INTO notification (receiver_id, type, invited_user_id, project_id)
VALUES
(1, 'ACCEPTED_INVITATION', 3, 1);

-- Populate the notification table with an assignment notification
-- Notify developer with ID 4 about their assignment to task ID 2
INSERT INTO notification (receiver_id, type, task_id)
VALUES
(4, 'ASSIGN', 2);

-- Populate the notification table with a completed task notification
-- Notify the product owner that the task was completed by developer with ID 3
INSERT INTO notification (receiver_id, type, task_id, completed_by)
VALUES
(1, 'COMPLETED_TASK', 4, 3);