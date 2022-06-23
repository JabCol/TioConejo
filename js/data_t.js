$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "lengthMenu": "Mostrar " +`
            <select>
                <option value='5'>5</option>
                <option value='25'>25</option>
                <option value='50'>50</option>
                <option value='-1'>All</option>
            </select>
            `+ "registros en esta página",
            "zeroRecords": "No se ha encontrado nada",
            "info": "Mostrando página _PAGE_ of _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de un total de  _MAX_ registros)",
            "search": "Buscar: ",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    } );
} );