CREATE TYPE moderation_statuses AS ENUM (
	'PENDING',
	'APPROVED',
	'REJECTED'
);

ALTER TABLE questions
ADD COLUMN moderation_status moderation_statuses NOT NULL DEFAULT 'PENDING';

ALTER TABLE categories
ADD COLUMN moderation_status moderation_statuses NOT NULL DEFAULT 'PENDING';

CREATE INDEX moderation_status_idx ON categories (moderation_status);