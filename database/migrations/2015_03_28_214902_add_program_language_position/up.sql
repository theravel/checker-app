ALTER TABLE program_languages
ADD COLUMN "position" int NOT NULL;

CREATE INDEX p_lang_pos_index ON program_languages USING btree ("position");