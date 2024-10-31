import { cleanModal, insertItems, insertMessgeValidate, toastController } from './app.js';


let table = $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "api/product/get",
        error: function (xhr) {
            if (xhr.status === 401) {
                window.location.href = '/login';
            }
        }
    },
    order: [[2, 'desc']],
    columns: [
        { data: "name" },
        { data: "unit_measure" },
        { data: "shipment_date" },
        { data: "stock" },
        { data: "brand.name" },
        // {
        //     data: "created_at",
        //     render: function (data, type, row) {
        //         // Formatear la fecha y hora
        //         var fecha = new Date(data);
        //         return fecha.toLocaleDateString();
        //     }
        // },
        {
            data: "status",
            render: function (data, type, row) {
                let text;
                let color;

                text = data == 0 ? 'Activo' : 'Inactivo'
                color = data == 0 ? 'bg-label-success' : 'bg-label-danger'

                return '<span id="delete" class="badge ' + color + ' me-1 cursor-pointer">' + text + '</span>';

            }
        },
        { // Columna adicional
            data: null,
            defaultContent: `
            
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                          data-bs-target="#modalCenter" id="edit">
                    <i class='bx bxs-edit-alt'></i>
            </button>
      
            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                          data-bs-target="#modalImage" id="image">
                    <i class='bx bx-image'></i>
            </button>

            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                          data-bs-target="#modalReset" id="reset">
                    <i class='bx bx-trash'></i>
            </button>
            
            `
        },
    ],
    createdRow: function (row, data) {
        $(row).find('#edit').attr('data-id', data.id);
        $(row).find('#delete').attr('data-id', data.id);
        $(row).find('#image').attr('data-id', data.id);
    }
});


let method;
let url;
let mainId;
// Abrir modal de registro
$('body').on('click', '#btnModalRegister', function () {
    cleanModal("#form", '#closeModal');

    $('#modalCenterTitle').text('Registrar Producto')

    url = 'api/product/register';
    method = 'POST';
})

// Abrir modal para edicion
$('body').on('click', '#edit', function () {
    $('#modalCenterTitle').text('Actualizar Producto');
    mainId = $(this).data('id');

    url = 'api/product/update/' + mainId;
    method = 'PUT';

    $.ajax({
        url: 'api/product/get/' + mainId,
        success: function (response) {
            console.log('DATA: ', response.data);


            let brandId = response.data.brand_id;
            let brandName = response.data.brand.name;

            // Prellenar el select con el valor preseleccionado
            let newOption = new Option(brandName, brandId, false, false);
            $('#brand_id').append(newOption).val(brandId);

            $('#nameItemModal').text(response.data.name);
            insertItems(response.data)
        },
        error: function (error) {
            alert('Error interno. Contactse con el proovedor: ' + error)
        }
    })
})

// Solicitud para reigstrar Producto
$('body').on('submit', '#form', function (e) {
    e.preventDefault();

    const data = $(this).serialize();

    $.ajax({
        url: url,
        method: method,
        data: data,
        success: function (response) {
            console.log('RESP: ', response);
            if (response.success == true) {
                toastController(
                    response.title,
                    response.message
                )
                cleanModal("#form", '#closeModal');

                table.ajax.reload(null, false);

            } else if (response.errors) {
                insertMessgeValidate(response.errors)
            }
        },
        error: function (error) {
            alert('Error interno. Contacte al proovedor: ' + error)
            console.log('ERRO REGISTER: ', error);

        }
    })
})

// Activar o desactivar Producto
$('body').on('click', '#delete', function () {
    const id = $(this).data('id');

    $.ajax({
        url: 'api/product/changestatus/' + id,
        method: 'PUT',
        success: function (response) {
            console.log('DISABLED: ', response);
            if (response.success) {
                table.ajax.reload(null, false);
            } else {
                toastController(response.title, response.message)
            }
        },
        error: function (error) {
            console.log(error);
            alert('Error interno: ', error)
        }
    })
});

// Cargar ID para eliminar
$('body').on('click', '#reset', function () {
    let row = $(this).closest('tr');
    let rowData = $('#table').DataTable().row(row).data();

    $('#nameItemReset').text(rowData.name);

    mainId = rowData.id;
})

// Restaurar
$('body').on('click', '#btnReset', function () {
    $.ajax({
        url: 'api/product/delete/' + mainId,
        method: 'delete',
        success: function (response) {
            table.ajax.reload(null, false);
            toastController(response.title, response.message)
        },
        error: function (error) {
            console.log('ERROR RESTORE: ', error);
            alert('Error interno del servidor: ' + error)

        }
    })

})

// Obtenter el ID del producto
$('body').on('click', '#image', function () {
    mainId = $(this).data('id');

    $('#imagePreview').empty(); // Limpiar el contenedor de imágenes al abrir el modal

    // Obtener imágenes existentes
    $.ajax({
        url: `/api/product/images/${mainId}`, // Cambia a tu endpoint correcto
        type: 'GET',
        success: function (images) {
            // Mostrar las imágenes existentes en el modal
            images.forEach(image => {
                const imageContainer = `
                    <div class="col-3 mb-2 image-container" data-filename="${image.name}">
                        <button type="button" class="btn bg-label-danger btn-sm remove-image" aria-label="Eliminar imagen">
                            X
                        </button>
                        <img src="/product_files/${image.product_id}/${image.name}" class="img-thumbnail" alt="${image.name}" />
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mainImage" id="mainImage${image.id}" value="${image.name}" ${image.is_main ? 'checked' : ''}>
                            <label class="form-check-label" for="mainImage${image.id}">
                                Portada
                            </label>
                        </div>
                    </div>
                `;
                $('#imagePreview').append(imageContainer);
            });
        },
        error: function (xhr) {
            console.error('Error al obtener las imágenes:', xhr);
        }
    });
})


// Cargar imagenes
$('body').on('change', 'input[type="file"]', function (event) {
    const fileInput = $(this);
    const fileNumber = fileInput.data('number');
    const files = event.target.files;

    // Asegurarse de que solo se selecciona un archivo
    if (files.length > 0) {
        const file = files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            // Mostrar la imagen en el contenedor correspondiente
            $(`#imagePreview${fileNumber}`).html(`<img src="${e.target.result}" class="img-thumbnail" alt="Imagen ${file.name}" />`);
            // Mostrar el botón de eliminar
            $(`.remove-image[data-number="${fileNumber}"]`).show();
        };
        reader.readAsDataURL(file);
    }
});

// Manejador para el botón de eliminar
$('body').on('click', '.remove-image', function () {
    const fileNumber = $(this).data('number');
    // Limpiar el input de archivo y la vista previa
    $(`input[name="image${fileNumber}"]`).val('');
    $(`#imagePreview${fileNumber}`).html('');
    // Ocultar el botón de eliminar
    $(this).hide();
});

// Manejador para el envío del formulario
$('body').on('submit', '#formImages', function (e) {
    e.preventDefault();

    const imagesToUpload = [];

    // Iterar sobre los inputs de archivos
    $('input[type="file"]').each(function () {
        const fileInput = $(this);
        const fileNumber = fileInput.data('number');
        const file = fileInput[0].files[0]; // Obtener el archivo

        if (file) {
            const main = $(`input[name="mainImage"]:checked`).val() == fileNumber ? 1 : 0; // 1 si es la imagen principal

            // Crear un objeto para enviar
            imagesToUpload.push({
                image: file,
                main: main,
                number: fileNumber // Añadir el número para el manejo en el backend
            });
        }
    });

    // Aquí puedes enviar el arreglo de imágenes a tu API
    const formData = new FormData();
    formData.append('images', JSON.stringify(imagesToUpload)); // Convertir a JSON

    $.ajax({
        url: 'api/product/upload/' + mainId, // Cambia esto a tu endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Imágenes subidas exitosamente:', response);
            // Manejar la respuesta
        },
        error: function (xhr) {
            console.error('Error al subir las imágenes:', xhr);
            // Manejar el error
        }
    });
});
