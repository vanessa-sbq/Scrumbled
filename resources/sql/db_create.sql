-- Relation: admin
CREATE TABLE
    admin (
        id BIGSERIAL PRIMARY KEY,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        remember_token VARCHAR(255),
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: authenticated_user
CREATE TYPE account_status AS ENUM ('ACTIVE', 'BANNED');

CREATE TABLE
    authenticated_user (
        id BIGSERIAL PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        bio TEXT,
        picture TEXT,
        is_public BOOLEAN NOT NULL DEFAULT TRUE,
        status account_status NOT NULL DEFAULT 'ACTIVE',
        remember_token VARCHAR(255),
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
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
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
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
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        PRIMARY KEY (developer_id, project_id)
    );

-- Relation: sprint
CREATE TABLE
    sprint (
        id BIGSERIAL PRIMARY KEY,
        project_id BIGINT NOT NULL REFERENCES project (id) ON DELETE CASCADE ON UPDATE CASCADE,
        name VARCHAR(255),
        start_date TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
        end_date TIMESTAMPTZ CHECK (end_date > start_date),
        is_archived BOOLEAN NOT NULL DEFAULT FALSE
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
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
    );

-- Relation: comment
CREATE TABLE
    comment (
        id BIGSERIAL PRIMARY KEY,
        task_id BIGINT NOT NULL REFERENCES task (id) ON DELETE CASCADE ON UPDATE CASCADE,
        user_id BIGINT REFERENCES authenticated_user (id) ON DELETE SET NULL ON UPDATE CASCADE,
        description TEXT NOT NULL,
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW ()
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
        created_at TIMESTAMPTZ NOT NULL DEFAULT NOW (),
        is_read BOOLEAN NOT NULL DEFAULT FALSE
    );