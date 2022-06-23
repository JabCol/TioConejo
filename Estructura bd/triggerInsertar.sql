-- -----------------------------------------------------------------------------------------------------------------
-- Se le añade a a tabla grado dos columnas
alter table grado
add column total_estudiantes integer default (0),
add column total_materias integer default (0);   
-- --------------------------------------------------------------------------------------------------------------
-- Cada vez que se inserte un estudiante, se aumentará el etotal estudiante en un grado correspondiente
CREATE OR REPLACE FUNCTION incrementarEstudiantes()
returns trigger as $incrementarE$
begin
	update grado 
	set total_estudiantes = total_estudiantes+1 
	where id_grado=new.id_grado2;
	return new;
end;
$incrementarE$
language plpgsql;

-- Ejecutar trigger despues de insertar 
create TRIGGER incrementarE after INSERT on estudiante
for each row EXECUTE procedure incrementarEstudiantes();
-- --------------------------------------------------------------------------------------------------------------
-- Cada vez que se inserte una materia, se aumentará el etotal estudiante en un grado correspondiente
CREATE OR REPLACE FUNCTION incrementarMaterias()
returns trigger as $incrementarM$
begin
	update grado 
	set total_materias = total_materias+1 
	where id_grado=new.id_grado;
	return new;
end;
$incrementarM$
language plpgsql;

-- Ejecutar trigger despues de insertar 
create TRIGGER incrementarM after INSERT on grado_materia
for each row EXECUTE procedure incrementarMaterias();