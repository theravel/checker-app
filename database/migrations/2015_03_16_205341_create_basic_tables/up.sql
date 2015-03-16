CREATE TYPE entity_types AS ENUM (
	'QUESTION',
	'ANSWER'
);

CREATE TABLE program_languages (
	id integer NOT NULL,
	name character varying(50) NOT NULL
);

CREATE SEQUENCE program_languages_id_seq
	START WITH 1
	INCREMENT BY 1
	NO MINVALUE
	NO MAXVALUE
	CACHE 1;

ALTER SEQUENCE program_languages_id_seq OWNED BY program_languages.id;

CREATE TABLE questions (
	id integer NOT NULL,
	type smallint NOT NULL,
	p_language_id integer NOT NULL
);

COMMENT ON COLUMN questions.p_language_id IS 'Programming language ID';

CREATE SEQUENCE questions_id_seq
	START WITH 1
	INCREMENT BY 1
	NO MINVALUE
	NO MAXVALUE
	CACHE 1;

ALTER SEQUENCE questions_id_seq OWNED BY questions.id;

CREATE TABLE texts (
	id integer NOT NULL,
	entity_id bigint NOT NULL,
	entity_type entity_types NOT NULL,
	language character varying(10) NOT NULL,
	text text NOT NULL
);

CREATE SEQUENCE texts_id_seq
	START WITH 1
	INCREMENT BY 1
	NO MINVALUE
	NO MAXVALUE
	CACHE 1;

ALTER SEQUENCE texts_id_seq OWNED BY texts.id;

ALTER TABLE ONLY program_languages ALTER COLUMN id SET DEFAULT nextval('program_languages_id_seq'::regclass);

ALTER TABLE ONLY questions ALTER COLUMN id SET DEFAULT nextval('questions_id_seq'::regclass);

ALTER TABLE ONLY texts ALTER COLUMN id SET DEFAULT nextval('texts_id_seq'::regclass);

ALTER TABLE ONLY program_languages
	ADD CONSTRAINT program_languages_pkey PRIMARY KEY (id);

ALTER TABLE ONLY texts
	ADD CONSTRAINT texts_pkey PRIMARY KEY (id);

CREATE INDEX fki_p_language_id ON questions USING btree (p_language_id);

CREATE UNIQUE INDEX texts_entity_id_entity_type_language_idx ON texts USING btree (entity_id, entity_type, language);

ALTER TABLE ONLY questions
	ADD CONSTRAINT p_language_id FOREIGN KEY (p_language_id) REFERENCES program_languages(id);