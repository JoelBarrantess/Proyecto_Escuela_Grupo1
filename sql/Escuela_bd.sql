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
create table if not exists tbl_login(
    id_login int not null auto_increment,
    username varchar(50) not null,
    password varchar(50) not null,
    tipo_usuario ENUM('administrador', 'profesor', 'alumno') not null,
    id_profesor int,
    id_alumno int,
    primary key(id_login),
    foreign key(id_profesor) references tbl_profesor(id_profesor),
    foreign key(id_alumno) references tbl_alumno(id_alumno)
);


/* Trigger alumnos */
DELIMITER //
CREATE TRIGGER trigger_alumnos
BEFORE INSERT ON tbl_alumno
FOR EACH ROW
BEGIN
   SET NEW.nom_alu = CONCAT(UPPER(LEFT(NEW.nom_alu, 1)), LOWER(SUBSTRING(NEW.nom_alu, 2)));
   SET NEW.apellido1_alu = CONCAT(UPPER(LEFT(NEW.apellido1_alu, 1)), LOWER(SUBSTRING(NEW.apellido1_alu, 2)));
   SET NEW.apellido2_alu = CONCAT(UPPER(LEFT(NEW.apellido2_alu, 1)), LOWER(SUBSTRING(NEW.apellido2_alu, 2)));
END //
DELIMITER ;


/* Trigger profesores */
DELIMITER //
CREATE TRIGGER trigger_profesores
BEFORE INSERT ON tbl_profesor
FOR EACH ROW
BEGIN
   SET NEW.nom_prof = CONCAT(UPPER(LEFT(NEW.nom_prof, 1)), LOWER(SUBSTRING(NEW.nom_prof, 2)));
   SET NEW.apellido1_prof = CONCAT(UPPER(LEFT(NEW.apellido1_prof, 1)), LOWER(SUBSTRING(NEW.apellido1_prof, 2)));
   SET NEW.apellido2_prof = CONCAT(UPPER(LEFT(NEW.apellido2_prof, 1)), LOWER(SUBSTRING(NEW.apellido2_prof, 2)));
END //
DELIMITER ;


/* Trigger login profe */
DELIMITER //

CREATE TRIGGER trigger_login_profesor
AFTER INSERT ON tbl_profesor
FOR EACH ROW
BEGIN
    DECLARE username_prof VARCHAR(50);
    DECLARE password_prof VARCHAR(50);

    SET username_prof = CONCAT(LOWER(LEFT(NEW.nom_prof, 1)), LOWER(NEW.apellido1_prof));
    SET password_prof = SUBSTRING(SHA2(CONCAT(NOW(), RAND()), 256), 1, 8);

    INSERT INTO tbl_login (username, password, tipo_usuario, id_profesor) 
    VALUES (username_prof, password_prof, 'profesor', NEW.id_profesor);
END //

DELIMITER ;


/* Trigger login alumnos */
DELIMITER //

CREATE TRIGGER trigger_login_alumno
AFTER INSERT ON tbl_alumno
FOR EACH ROW
BEGIN
    DECLARE username_alu VARCHAR(50);
    DECLARE password_alu VARCHAR(50);

    SET username_alu = CONCAT(LOWER(LEFT(NEW.nom_alu, 1)), LOWER(NEW.apellido1_alu));
    SET password_alu = SUBSTRING(SHA2(CONCAT(NOW(), RAND()), 256), 1, 8);

    INSERT INTO tbl_login (username, password, tipo_usuario, id_alumno) 
    VALUES (username_alu, password_alu, 'alumno', NEW.id_alumno);
END //

DELIMITER ;

-- Trigger eliminar login alumnos
DELIMITER //

CREATE TRIGGER trigger_delete_login_alumno
BEFORE DELETE ON tbl_alumno
FOR EACH ROW
BEGIN
    DELETE FROM tbl_login WHERE id_alumno = OLD.id_alumno;
END //

DELIMITER ;

-- Trigger eliminar login profesores
DELIMITER //

CREATE TRIGGER trigger_delete_login_profesor
BEFORE DELETE ON tbl_profesor
FOR EACH ROW
BEGIN
    DELETE FROM tbl_login WHERE id_profesor = OLD.id_profesor;
END //

DELIMITER ;


-- Tres login asegurados para pruebas
insert into tbl_login (username, password,tipo_usuario) values ('admin','admin','administrador');
insert into tbl_login (username, password,tipo_usuario) values ('profe','qazQAZ123','profesor');
insert into tbl_login (username, password,tipo_usuario) values ('alumno','qazQAZ123','alumno');


-- Inserts para profesores
insert into tbl_profesor (nom_prof, apellido1_prof, apellido2_prof, dni_prof, email_prof, telf_prof) values 
('Walter', 'Hartwell', 'White', '76523475Z', 'walterwhite@gmail.com', '624732412'),
('Maria', 'López', 'García', '45678901X', 'marialopez@gmail.com', '632187654'),
('Pedro', 'Martínez', 'Rodríguez', '12345678A', 'pedromartinez@gmail.com', '678945612'),
('Laura', 'González', 'Sánchez', '98765432B', 'lauragonzalez@gmail.com', '698745123'),
('Manuel', 'Fernández', 'Pérez', '56789012C', 'manuelfernandez@gmail.com', '687451239'),
('Ana', 'Sánchez', 'Martínez', '34567890D', 'anasanchez@gmail.com', '612349875'),
('Carlos', 'García', 'Fernández', '23456789E', 'carlosgarcia@gmail.com', '645123987'),
('Elena', 'Rodríguez', 'López', '67890123F', 'elenarodriguez@gmail.com', '654789123'),
('Sara', 'Pérez', 'Gómez', '89012345G', 'saraperez@gmail.com', '623478915'),
('Javier', 'Martínez', 'González', '45678901H', 'javiermartinez@gmail.com', '687512394'),
('Lucía', 'Sánchez', 'Fernández', '12345678I', 'luciasanchez@gmail.com', '698754123'),
('Diego', 'Gómez', 'Martínez', '67890123J', 'diegogomez@gmail.com', '612349785'),
('Carmen', 'Martín', 'Sánchez', '23456789K', 'carmenmartin@gmail.com', '645178923'),
('Andrés', 'López', 'Martínez', '89012345L', 'andreslopez@gmail.com', '623487591'),
('María José', 'García', 'Gómez', '34567890M', 'mariajosegarcia@gmail.com', '654129837');


-- Inserts para cursos
insert into tbl_clase (nombre_clase, codi_clase,id_profesor) values 
('Sistemas Microinformatics i Xarxes', 'SMX',1),
('Desenvolupament de Aplicacions en Entorns Web', 'DAW',5),
('Administració de Sistemes Informatics i Xarxes', 'ASIX',3),
('Gestión de Proyectos Informáticos', 'GPI',2);


-- Inserts para alumnos
insert into tbl_alumno (nom_alu, apellido1_alu, apellido2_alu, dni_alum, email_alum, telf_alum, id_clase) values 
('Julian', 'Ramos', 'Carbia', '02194242L', 'yeruzamw@gmail.com', '654321098', 1),
('Lucia', 'Fernandez', 'Ibañez', '12345678N', 'luciafernandez@gmail.com', '623487915', 1),
('Pedro', 'Sánchez', 'Pérez', '23456789O', 'pedrosanchez@gmail.com', '645219837', 4),
('Lucía', 'Martínez', 'Pérez', '34567890P', 'luciamartinez@gmail.com', '623489751', 1),
('Sara', 'Gómez', 'López', '45678901Q', 'saragomez@gmail.com', '654218937', 1),
('Oscar', 'Lopez', 'Correa', '56789012R', 'oscarlopez@gmail.com', '645298173', 2),
('Carmen', 'Pérez', 'Sánchez', '67890123S', 'carmenperez@gmail.com', '623487591', 3),
('Manuel', 'García', 'Martínez', '78901234T', 'manuelgarcia@gmail.com', '654129837', 2),
('Elena', 'López', 'Gómez', '89012345U', 'elenalopez@gmail.com', '623498175', 2),
('Andrés', 'Martínez', 'Fernández', '90123456V', 'andresmartinez@gmail.com', '645238971', 2),
('María', 'Fernández', 'Sánchez', '01234567W', 'mariafernandez@gmail.com', '623487129', 3),
('Javier', 'Gómez', 'López', '12345678X', 'javiergomez@gmail.com', '654291837', 3),
('Laura', 'Martín', 'González', '23456789Y', 'lauramartin@gmail.com', '623487915', 4),
('Carlos', 'Sánchez', 'Pérez', '34567890Z', 'carlossanchez@gmail.com', '645219837', 3),
('Ana', 'Pérez', 'Martínez', '45678901A', 'anaperez@gmail.com', '623489751', 4);



