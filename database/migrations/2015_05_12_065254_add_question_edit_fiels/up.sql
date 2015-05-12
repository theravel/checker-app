ALTER TABLE questions
	ADD COLUMN user_id integer NULL,
	ADD COLUMN parent_question_ids integer[] NULL,
	ADD CONSTRAINT p_user_id FOREIGN KEY (user_id)
		REFERENCES users (id) MATCH SIMPLE
		ON UPDATE CASCADE ON DELETE CASCADE;