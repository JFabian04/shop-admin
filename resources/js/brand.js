// Importa tu archivo CSS de Select2 si es necesario
// import $ from 'jquery';
// import 'select2';
// import '../sass/app.scss'; // Asegúrate de que la ruta es correcta
// import { cleanMessageValidation, cleanModal, insertItems, insertMessgeValidate, toastController } from './app.js';



let table = $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "api/brand/get",
        type: "get"
    },
    columns: [
        { data: "name" },
        { data: "identifier" },
        {
            data: "status",
            render: function (data, type, row) {
                // Si el valor de 'status' es '0', mostrar 'Activado' con fondo verde
                if (data == 0) {
                    return '<span id="delete" class="cursor-pointer bg-gradient-to-tl from-green-600 to-green-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Activo</span>';
                }
                // Si el valor de 'status' es '1', mostrar 'Inactivo' con fondo rojo
                else {
                    return '<span id="delete" class="cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Inactivo</span>';

                }

            }
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            defaultContent:
                `<div class="flex" style="gap:20px">
                    <div class="w-6 btn btn-primary btn-sm cursor-pointer" id="edit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    </div>

                    <div class="w-6 btn btn-primary btn-sm cursor-pointer" id="delete">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    </div>
                </div>
            `
            // <button class="btn btn-primary btn-sm" id="delete">
            // <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            // <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            // </svg>

            // </button>
        },
    ],
    createdRow: function (row, data) {
        $(row).find('#edit').attr('data-id', data.id);
        $(row).find('#delete').attr('data-id', data.id);
    }
    // columnDefs: [
    //     {
    //         targets: [2, 3], // Índice de la columna de fecha y hora
    //         render: function (data, type, row) {
    //             // Formatear la fecha y hora
    //             var fecha = new Date(data);
    //             return fecha.toLocaleDateString() + ' ' + fecha.toLocaleTimeString();
    //         }
    //     }
    // ]
    // responsive: true,
});


// let method;
// let url;
// let idUser;
// // Abrir modal de registro
// $('body').on('click', '#btnModalRegister', function () {
//     cleanModal("#form", '#closeModal');

//     $('#modalCenterTitle').text('Registrar Usuario')

//     url = 'api/user/register';
//     method = 'POST';
// })

// // Abrir modal para edicion
// $('body').on('click', '#edit', function () {
//     $('#modalCenterTitle').text('Actualizar Usuario');
//     idUser = $(this).data('id');

//     url = 'api/user/update/' + idUser;
//     method = 'PUT';

//     $.ajax({
//         url: 'api/user/get/' + idUser,
//         success: function (response) {
//             console.log('DATA: ', response.data);

//             $('#nameItemModal').text(response.data.name);
//             insertItems(response.data)
//         },
//         error: function (error) {
//             alert('Error interno. Contactse con el proovedor: ' + error)
//         }
//     })
// })

// // Solicitud para reigstrar usuario
// $('body').on('submit', '#form', function (e) {
//     e.preventDefault();

//     const data = $(this).serialize();

//     $.ajax({
//         url: url,
//         method: method,
//         data: data,
//         success: function (response) {
//             console.log('RESP: ', response);
//             if (response.success == true) {
//                 toastController(
//                     response.title,
//                     response.message
//                 )
//                 cleanModal("#form", '#closeModal');

//                 table.ajax.reload(null, false);

//             } else {
//                 insertMessgeValidate(response.errors)
//             }
//         },
//         error: function (error) {
//             alert('Error interno. Contacte al proovedor: ' + error)
//             console.log('ERRO REGISTER: ', error);

//         }
//     })
// })

// // Activar o desactivar usuario
// $('body').on('click', '#delete', function () {
//     const id = $(this).data('id');

//     $.ajax({
//         url: '/api/user/delete/' + id,
//         method: 'PUT',
//         success: function (response) {
//             console.log('DISABLED: ', response);
//             table.ajax.reload();
//         },
//         error: function (error) {
//             console.log(error);
//             alert('error interno del serividor: ', error)
//         }
//     })
// });

// // Restaurar contraseña
// $('body').on('click', '#reset', function () {
//     // Obtiene los datos de la fila
//     let row = $(this).closest('tr');
//     let rowData = $('#table').DataTable().row(row).data();

//     $('#nameItemReset').text(rowData.name);

//     idUser = rowData.id;
// })

// // Restaurar
// $('body').on('click', '#btnReset', function () {
//     $.ajax({
//         url: 'api/user/restore/' + idUser,
//         method: 'PUT',
//         success: function (response) {
//             console.log(response);
//             toastController(response.title, response.message)
//         },
//         error: function (error) {
//             console.log('ERROR RESTORE: ', error);
//             alert('Error interno del servidor: ' + error)

//         }
//     })

// })