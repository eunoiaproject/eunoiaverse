mysql -u cipher -p eunoiaverse_db < backup.sql
USE DATABASE eunoiaverse_db;
SELECT * FROM users WHERE id = 1;
UPDATE users SET last_login = NOW() WHERE id = 1;
INSERT INTO logs (user_id, action, timestamp) VALUES (1, 'login', NOW());   
DELETE FROM sessions WHERE user_id = 1 AND expired = 1;         
COMMIT;
EXIT;
