CREATE TABLE answers (
	id serial NOT NULL,
	question_id integer NOT NULL,
	is_correct boolean NOT NULL,
	CONSTRAINT answers_pkey PRIMARY KEY (id),
	CONSTRAINT p_question_id FOREIGN KEY (question_id)
		REFERENCES questions (id) MATCH SIMPLE
		ON UPDATE CASCADE ON DELETE CASCADE
);