-- SQL to fix database issues on production server
-- Run this SQL in your phpMyAdmin or MySQL client

-- Fix 1: Add last_used_at column to personal_access_tokens (for Laravel Sanctum)
ALTER TABLE personal_access_tokens ADD COLUMN last_used_at timestamp NULL AFTER abilities;

-- Fix 2: Add score column to exam_sessions (for exam results)
ALTER TABLE exam_sessions ADD COLUMN score INT NULL AFTER end_time;

-- If you get error that column exists, use this to check:
-- DESCRIBE personal_access_tokens;
-- DESCRIBE exam_sessions;

