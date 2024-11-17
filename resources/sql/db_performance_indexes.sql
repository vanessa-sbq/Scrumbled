-- INDEXES

-- The notification table requires efficient filtering by receiver_id, as it is frequently accessed in queries. 
-- A hash index on receiver_id was chosen because it offers fast lookup times, which is suitable given the cardinality of this column. 
-- Since the table is large and accessed frequently, a hash index will improve query performance.
CREATE INDEX idx_notification_receiver_id ON notification USING HASH (receiver_id);

-- The comment table is very large, and many queries filter comments by task. 
-- A B-tree index on task_id was chosen to support range queries and to allow clustering for faster retrieval of task-related comments. 
-- Clustering ensures related records are stored close together, improving access time for sequential queries.
CREATE INDEX idx_comment_task_id ON comment USING BTREE (task_id);

-- The task table requires frequent filtering by project_id to retrieve all tasks under a specific project. 
-- A B-tree index on project_id was selected to support efficient retrieval for these queries, and clustering was not necessary since tasks do not need to be stored in project-related order.
CREATE INDEX idx_task_project_id ON task USING BTREE (project_id);