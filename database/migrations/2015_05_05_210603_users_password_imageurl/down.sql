ALTER TABLE users
	DROP COLUMN image_url;
ALTER TABLE users
	ALTER COLUMN password SET NOT NULL;