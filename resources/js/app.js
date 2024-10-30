// import './bootstrap';

import jQuery from 'jquery';
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive';
import 'animate.css';


window.$ = window.jQuery = jQuery;
$.ajaxSetup({
    headers: {
        // 'Authorization': 'Bearer ' + localStorage.getItem('token'), // Aquí agregas el Bearer Token
        // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
});

// DATATABLE TRADUCTION
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            // "first": "1",
            // "last": "Ultimo",
            // "next": ">>",
            // "previous": "Anterior"
        }
    },
});



