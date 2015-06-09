ALTER TABLE questions
	DROP COLUMN parent_question_ids;

CREATE TABLE questions_hierarchy (
	id serial NOT NULL, 
	question_id integer NOT NULL, 
	parent_id integer, 
	children_ids integer[], 
	PRIMARY KEY (id), 
	FOREIGN KEY (question_id) REFERENCES questions (id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (parent_id) REFERENCES questions (id) ON UPDATE NO ACTION ON DELETE NO ACTION
);