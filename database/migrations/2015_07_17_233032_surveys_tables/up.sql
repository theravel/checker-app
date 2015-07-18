CREATE TABLE surveys (
	id serial,
	name character varying NOT NULL,
	description character varying,
	created_at timestamp without time zone,
	updated_at timestamp without time zone,
	PRIMARY KEY (id)
);

CREATE TABLE user_surveys (
	id serial,
	user_id integer,
	session_id character varying,
	survey_id integer NOT NULL,
	created_at timestamp without time zone,
	updated_at timestamp without time zone,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION,
	FOREIGN KEY (survey_id) REFERENCES surveys (id) ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE survey_questions (
	id serial,
	survey_id integer NOT NULL,
	question_id integer NOT NULL,
	"position" integer NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (survey_id) REFERENCES surveys (id) ON UPDATE NO ACTION ON DELETE NO ACTION,
	FOREIGN KEY (question_id) REFERENCES questions (id) ON UPDATE NO ACTION ON DELETE NO ACTION
);