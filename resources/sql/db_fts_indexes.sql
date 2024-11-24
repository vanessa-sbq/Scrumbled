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

-- Add column to task to store computed ts_vectors.
ALTER TABLE task
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION task_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A') ||
      setweight(to_tsvector('english', NEW.description), 'B')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF ((NEW.title <> OLD.title) OR (NEW.description <> OLD.description)) THEN
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.title), 'A') ||
        setweight(to_tsvector('english', NEW.description), 'B')
      );
    END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on task.
CREATE TRIGGER task_search_update
  BEFORE INSERT OR UPDATE ON task
  FOR EACH ROW
  EXECUTE PROCEDURE task_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX idx_task_search ON task USING GIN (tsvectors);