ALTER TABLE questions
DROP COLUMN IF EXISTS moderation_status;

ALTER TABLE categories
DROP COLUMN IF EXISTS moderation_status;

DROP TYPE IF EXISTS moderation_statuses;