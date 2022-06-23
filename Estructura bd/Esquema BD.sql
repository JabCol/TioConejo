--CREACION DE LA TABLA ADMIN
create table IF NOT EXISTS Admin (
    id_admin serial,
    nombre_usuario varchar(100) not null unique,
    password varchar(100) not null,
    primary key (id_admin)
);

--CREACION DE LA TABLA GRADO
create domain JORNADA AS text NOT NULL
check ( value='MAÑANA'
        or
        value='TARDE');
		
create table IF NOT EXISTS Grado(
	id_grado serial,
	nombre_grado varchar(40),
	jornada JORNADA,
	id_admin1 integer,
	ultimo_cambio serial,
	primary key (id_grado),
	foreign key (id_admin1) references Admin (id_admin),
	foreign key (ultimo_cambio) references Admin (id_admin)
);

--CREACION DE LA TABLA ACUDIENTE
create table IF NOT EXISTS Acudiente (
    id_acudi serial,
    nombre_acudi varchar(100) not null,
    apellido_acudi varchar(100) not null,
    telefono_acudi varchar(40) not null,
    direccion_acudi varchar(40) not null,
    cedula varchar(40) not null unique,
	id_grado4 serial,
    primary key (id_acudi),
	foreign key (id_grado4) references grado (id_grado)
); 

--CREACION DE LA TABLA ESTUDIANTE
create domain GENERO AS text NOT NULL
check ( value='FEMENINO'
        or
        value='MASCULINO'
		or 
	   	value= 'OTRO');

create table IF NOT EXISTS Estudiante (
    id_estudiante serial,
    tarjeta_id varchar(100) not null unique,
	genero GENERO,
    nombre varchar(100) not null,
    apellido varchar(100) not null,
    fecha_nacimiento date not null,
	id_grado2 integer,
    id_acudi1 serial,
    primary key (id_estudiante),
    foreign key (id_grado2) references Grado(id_grado),
    foreign key (id_acudi1) references Acudiente(id_acudi)
);   

--CREACION DE LA TABLA MATERIA
create table IF NOT EXISTS Materia (
    id_materia serial,
    nombre_materia varchar(100) not null,
    primary key (id_materia)
);

--CREACION DE LA TABLA SOLICITUD
create table IF NOT EXISTS Solicitud (
	id_solicitud serial,
    nombre_aspi varchar(100) not null,
    apellido_aspi varchar(100) not null,
	tarjeta_id varchar(40) not null,
	genero_aspi GENERO,
    fecha_nacimiento date not null,
	id_grado3 integer,
    nombre_acudi varchar(100) not null,
    apellido_acudi varchar(100) not null,
    telefono_acudi varchar(40) not null,
    direccion_acudi varchar(40) not null,
	cedula_acudi varchar(40) not null,
    primary key (id_solicitud),
    foreign key (id_grado3) references Grado(id_grado)
); 

--CREACION DE LA TABLA GRADO-MATERIA
create table grado_materia (
	id_materia integer,
	id_grado integer,
	primary key (id_materia, id_grado),
	foreign key (id_materia) references Materia (id_materia),
	foreign key (id_grado) references Grado (id_grado)
);