-- Add deleted_at column to genres table
ALTER TABLE `genres` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL;
