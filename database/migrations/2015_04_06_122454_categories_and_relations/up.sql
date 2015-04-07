CREATE TABLE categories (
	id serial NOT NULL,
	"name" character varying(100) NOT NULL,
	created_at timestamp without time zone,
	updated_at timestamp without time zone,
	CONSTRAINT categories_pkey PRIMARY KEY (id)
);

CREATE TABLE question_category (
	id serial NOT NULL,
	question_id integer NOT NULL,
	category_id integer NOT NULL,
	CONSTRAINT question_category_pkey PRIMARY KEY (id),
	CONSTRAINT q_c_question_id FOREIGN KEY (question_id)
		REFERENCES questions (id) MATCH SIMPLE
		ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT q_c_category_id FOREIGN KEY (category_id)
		REFERENCES categories (id) MATCH SIMPLE
		ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE UNIQUE INDEX q_c_question_category_idx
	ON question_category USING btree (question_id, category_id);

CREATE INDEX q_c_category_idx
	ON question_category USING btree (category_id);