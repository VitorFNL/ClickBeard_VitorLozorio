CREATE DATABASE IF NOT EXISTS clickbeard
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;


CREATE USER IF NOT EXISTS 'clickbeardDBusuario'@'localhost' IDENTIFIED BY 'clickbeardDBsenha';

GRANT ALL PRIVILEGES ON clickbeard.* TO 'clickbeardDBusuario'@'localhost';

FLUSH PRIVILEGES;