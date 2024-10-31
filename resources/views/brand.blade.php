@extends('layouts.app')

@section('resources')
    @vite('resources/js/brand.js')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="display-6 fw-bold mt-4">
            <span class="bg-label-primary p-2 rounded">
                Administración de Marcas
            </span>
        </h4>
        <p>Administra las Marcas de tu tienda.</p>

        <div class="d-flex justify-content-end m-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter"
                id="btnModalRegister">
                <i class='bx bxs-add-to-queue'></i>
                Registrar
            </button>
        </div>

        <div class="card">        
            <div class="table-responsive text-nowrap p-4">
                <table class="table" id="table">
                    <thead>
                        <tr >
                            <th class="text-primary">Nombre</th>
                            <th class="text-primary">Indentificador</th>
                            <th class="text-primary">Fecha Registro</th>
                            <th class="text-primary">Estado</th>
                            <th class="text-primary">acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal  para reigstrar/editar-->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content" id="form">
                <div class="modal-header">
                    <h5 class="display-6 text-primary fw-bold" id="modalCenterTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeModal"></button>
                </div>

                <div class="mx-4">
                    <p class="badge bg-label-danger" id="nameItemModal"></p>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameWithTitle" class="form-label text-primary">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Ingrese el Nombre" />
                            <div class="error-validate" id="error-name"></div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Confirmar elimianr --}}
    <div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">¿Desea eliminar esta marca?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeModalPalm"></button>
                </div>

                <small class="text-primary" style="margin-left: 25px" id="nameItemReset"></small>

                <div class="modal-body">
                    <p>Eliminar esta marca, también eliminará todos los productos asociados.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnReset" data-bs-dismiss="modal">
                        Eliminar
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection
