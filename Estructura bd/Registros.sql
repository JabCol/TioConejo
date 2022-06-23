--INSERTAR REGISTROS EN LA TABLA ADMIN
insert into admin (nombre_usuario, password)
values 	('admin1', '123'),
		('admin2', '123');
		
--INSERTAR REGISTROS EN LA TABLA MATERIA
insert into Materia (nombre_materia)
values 	('español'),
		('ciencias naturales'),
		('ciencias sociales'),
		('matemáticas'),
		('sistemas'),
		('catedra de paz');
		
--INSERTAR REGISTROS EN LA TABLA GRADO
insert into Grado (nombre_grado, jornada, id_admin1, ultimo_cambio)
values 	('primero a', 'MAÑANA', 1, 1),
		('segundo b', 'MAÑANA', 1, 1),
		('tercero c', 'TARDE', 2, 2);
		
--INSERTAR REGISTROS EN LA TABLA ACUDIENTE		
insert into Acudiente (nombre_acudi, apellido_acudi, telefono_acudi, direccion_acudi, cedula, id_grado4)
values 	('Milton','Ortiz Aldama','3242323','Calle 80J #2bn-66','1234567', 1),
		('Carmen','Lopez Cortes','3243534','Calle 21N #2cn-76','10987654', 1),
		('Alonso','De la vista', '4331886','Kra 81 #45-66','1009123234', 2),
		('Andres','casas diaz','54889112','Calle 90 #2-66','55598878', 3);
		
--INSERTAR REGISTROS EN LA TABLA ESTUDIANTE
insert into Estudiante (nombre, apellido, genero,tarjeta_id,fecha_nacimiento, id_grado2, id_acudi1)
values 	('Maria Fernanda', 'Ortiz Rodriguez', 'FEMENINO', '1009123123', '12/12/2008', 1, 1),
		('Andres', 'Cortes Castro', 'MASCULINO', '1200987123', '03/04/2014', 1, 2),
		('Carlos Olmedo', 'Cortes Castro', 'MASCULINO', '23423400', '21/08/2008', 2, 3),
		('Juan camilo', 'De la villa Sierra', 'MASCULINO', '60009876', '20/10/2014', 3, 4);
        
--INSERTAR REGISTROS EN LA TABLA GRADO_MATERIA
insert into grado_materia
values 	(1,1),
		(2,1),
		(3,1),
		(1,2),
		(4,3);

--INSERTAR REGISTROS EN LA TABLA SOLICITUD
insert into solicitud (nombre_aspi, apellido_aspi,tarjeta_id,genero_aspi, fecha_nacimiento, id_grado3, nombre_acudi, apellido_acudi, telefono_acudi, direccion_acudi, cedula_acudi)
values 	('aspirante', '1', '123', 'MASCULINO', '21/08/2008', 1, 'acudiente', '1', '123', 'direccion1', '123456789'),
		('aspirante', '2', '456', 'MASCULINO', '21/08/2008', 1, 'acudiente', '2', '456', 'direccion2', '789456123'),
		('aspirante', '3', '789', 'MASCULINO', '21/08/2008', 2, 'acudiente', '3', '789', 'direccion3', '147258369'),
		('aspirante', '4', '1011', 'MASCULINO', '21/08/2008', 3, 'acudiente', '4', '1011', 'direccion4', '741852963');
		