--Banco de dados utilizado para criação da tabela de cliente e autenticação;

create database lanchonete;

use lanchonete;

create table cliente(
	id integer not null primary key AUTO_INCREMENT,
    nome varchar(30),
    telefone varchar(30),
    cep integer(7) not null,
    rua varchar(60) not null,
    numero integer not null,
    referencia varchar(100) not null
);

create table auth(
	id integer not null primary key,
	username varchar(30) not null,
    password varchar(30) not null,
    type varchar(30) not null
);