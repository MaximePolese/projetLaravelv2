-- init.sql
CREATE DATABASE IF NOT EXISTS craftcornerdata;
CREATE USER 'admin'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON craftcornerdata.* TO 'admin'@'%';
FLUSH PRIVILEGES;
