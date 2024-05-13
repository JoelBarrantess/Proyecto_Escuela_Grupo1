create database if not exists prueba_escuelas;
use prueba_escuelas;
create table if not exists login(
    username varchar(50) not null,
    password varchar(50) not null,
    primary key(username)
);
