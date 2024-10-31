@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="display-6 fw-bold mt-4">
            <span class="bg-label-primary p-2 rounded fs-1">
                Bienvenido a
            </span>
        </h4>

        <div class="d-flex justify-content-center bg-white my-4 shadow">
            <img src="{{ asset('assets/img/icon/logo.png') }}" alt="" class="img-fluid" srcset="">
        </div>

        <div class="bg-label-primary p-4 fs-5 rounded shadow">
            Se encuentra en el Panel de Administración, donde podrá gestionar de manera completa su inventario de productos
            y la administración de sus marcas. Acceda a todas las herramientas necesarias para mantener su catálogo
            actualizado, optimizar la organización de sus productos y asegurar una gestión eficiente de su inventario.
        </div>

    </div>
@endsection
