ALTER TABLE challenges 
ADD COLUMN file_path VARCHAR(500) NULL,
ADD COLUMN original_filename VARCHAR(255) NULL,
ADD COLUMN file_size BIGINT NULL;

CREATE INDEX idx_challenges_file_path ON challenges(file_path);
