CREATE DATABASE user_mng;
CREATE USER 'manager'@'localhost' IDENTIFIED BY 'test12345';
GRANT ALL PRIVILEGES ON user_mng.* TO 'manager'@'localhost';