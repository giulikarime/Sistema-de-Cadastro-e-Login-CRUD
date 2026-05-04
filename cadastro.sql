create database cadastro;

use cadastro;

create table users(
id int auto_increment primary key,
nome varchar(140),
email varchar(140) not null unique,
senha varchar(200) not null
);

CREATE USER 'new_app_user'@'localhost' IDENTIFIED BY 'bnp\\s8XDB32o';
GRANT ALL PRIVILEGES ON cadastro.* TO 'new_app_user'@'localhost';
FLUSH PRIVILEGES;
