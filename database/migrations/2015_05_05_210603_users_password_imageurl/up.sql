ALTER TABLE users
	ALTER COLUMN password DROP NOT NULL;
ALTER TABLE users
	ADD COLUMN image_url character varying(255);