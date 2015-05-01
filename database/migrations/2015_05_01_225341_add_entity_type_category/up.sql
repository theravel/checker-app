ALTER TYPE entity_types
	ADD VALUE 'CATEGORY';

UPDATE categories
	SET moderation_status = 'APPROVED';