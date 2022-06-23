-- --------------------------------------------------------------------------------------------------------------
-- Cada vez que se elimine un estudiante de un grado, se decrementará el total de estudiantes.
CREATE OR REPLACE FUNCTION decrementarEstudiante()
returns trigger as $decrementarE$
begin
	update grado 
	set total_estudiantes = total_estudiantes-1 
	where id_grado=old.id_grado2;
	return old;
end;
$decrementarE$
language plpgsql;

-- Ejecutar trigger antes de eliminar 
create TRIGGER decrementarE before DELETE on estudiante
for each row EXECUTE procedure decrementarEstudiante();
-- --------------------------------------------------------------------------------------------------------------
-- Cada vez que se elimine una materia de un grado, se decrementará el total de materias.
CREATE OR REPLACE FUNCTION decrementarMateria()
returns trigger as $decrementarM$
begin
	update grado 
	set total_materias = total_materias-1 
	where id_grado=old.id_grado;
	return old;
end;
$decrementarM$
language plpgsql;

-- Ejecutar trigger antes de eliminar 
create TRIGGER decrementarM before DELETE on grado_materia
for each row EXECUTE procedure decrementarMateria();