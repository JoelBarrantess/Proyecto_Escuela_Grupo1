create database if not exists proyecto_escuela;
use proyecto_escuela;
create table if not exists tbl_profesor(
    id_profesor int not null auto_increment,
    nom_prof varchar(50) not null,
    apellido1_prof varchar(50) not null,
    apellido2_prof varchar(50) not null,
    dni_prof char(9) not null,
    email_prof varchar(50),
    telf_prof char(9),
    primary key(id_profesor)
);
create table if not exists tbl_clase(
    id_clase int not null auto_increment,
    nombre_clase varchar(50) not null,
    codi_clase varchar(10),
    id_profesor int not null,
    primary key(id_clase),
    foreign key(id_profesor) references tbl_profesor(id_profesor)
);
create table if not exists tbl_alumno(
    id_alumno int not null auto_increment,
    nom_alu varchar(50) not null,
    apellido1_alu varchar(50) not null,
    apellido2_alu varchar(50) not null,
    dni_alum char(9) not null,
    email_alum varchar(50),
    telf_alum char(9),
    id_clase int not null,
    primary key(id_alumno),
    foreign key(id_clase) references tbl_clase(id_clase)
);

insert into tbl_profesor (nom_prof, apellido1_prof, apellido2_prof, dni_prof, email_prof, telf_prof) values ('John', 'Doe', 'Doe', '76523475Z', 'johndoe@gmail.com', '624732412');
insert into tbl_clase (nombre_clase, codi_clase,id_prof) values ('Sistemas Microinformatics i Xarxes', 'SMX',1);
insert into tbl_alumno (nom_alu, apellido1_alu, apellido2_alu, dni_alum, email_alum, telf_alum, id_clase) values ('Julian', 'Ramos', 'Carbia', '02194242L', 'yeruzamw@gmail.com', '654321098', 1);

