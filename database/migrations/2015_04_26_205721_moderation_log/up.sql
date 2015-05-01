CREATE TABLE moderation_logs (
	id serial NOT NULL,
	entity_id bigint NOT NULL,
	entity_type entity_types NOT NULL,
	moderation_status moderation_statuses NOT NULL,
	created_at timestamp without time zone,
	updated_at timestamp without time zone,
	CONSTRAINT moderation_logs_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX moderation_logs_entity_id_entity_type_created_idx
	ON moderation_logs
	USING btree (entity_id, entity_type, created_at);