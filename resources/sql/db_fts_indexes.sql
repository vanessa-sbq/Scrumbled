-----------------------------------------
-- FTS INDEXES
-----------------------------------------

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
CREATE INDEX idx_project_search ON project USING GIN (tsvectors);

-----------------------------------------
-- FTS INDEXES
-----------------------------------------

-- Add column to authenticated_user to store computed ts_vectors.
ALTER TABLE authenticated_user
ADD COLUMN tsvectors TSVECTOR;

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
    IF ((NEW.username <> OLD.username) OR (NEW.full_name <> OLD.full_name) OR (NEW.bio <> OLD.bio)) THEN
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
CREATE INDEX idx_authenticated_user_search ON authenticated_user USING GIN (tsvectors);