<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icon/logo.png') }}" />

    <title>MauritiApp</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('../assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('../assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('../assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link rel="stylesheet" href="//cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">

    <!-- Helpers -->
    <script src="{{ asset('../assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('../assets/js/config.js') }}"></script>

    @vite('resources/sass/datatables.scss')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('resources')


</head>

<body>
    @include('components.toast')

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <img src="{{ asset('assets/img/icon/logo.png') }}" alt="" width="180">
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                  
                    <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
                        <a href="/" class="menu-link ">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                 
                    <li class="menu-item {{ Request::is('marcas') ? 'active' : '' }}">
                        <a href="/marcas" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Tables">Marcas</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('productos') ? 'active' : '' }}">
                        <a href="/productos" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-box"></i>
                            <div data-i18n="Tables">Productos</div>
                        </a>
                    </li>
                </ul>
            </aside>
     
            <div class="layout-page" style="overflow-y: scroll; height: 100vh">

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">       
                        <div class="navbar-nav align-items-center"></div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/avatar.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../assets/img/avatars/avatar.png" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block nameUser"
                                                        id="nameUser">Admin</span>
                                                    <small class="text-muted text-capitalize"
                                                        id="role">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a type="button" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#modalCenterProfile" id="myProfile">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Mi Perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li id="logout">
                                        <a type="button" class="dropdown-item">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Cerrar Sesión</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>


                <div class="">
                    
                    @yield('content')

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                2024

                                . Hecho por
                                <a href="https://themeselection.com" target="_blank"
                                    class="footer-link fw-bolder">Fabián Ramos</a>
                            </div>
                            <div>
                                <img src="{{ asset('assets/img/icon/logo.png') }}" alt="" width="130">
                            </div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('../assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('../assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('../assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('../assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('../assets/js/main.js') }}"></script>

</body>

<!-- Modal Editar credenciales-->
<div class="modal fade" id="modalCenterProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="formDataAdmin" method="POST">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalCenterTitle">Editar Credenciales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeModal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Usuario</label>
                        <input type="text" id="name" name="name" class="form-control nameUser"
                            placeholder="Ingrese su Usuario" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Minimo 4 caracteres" />
                        <small id="passwordErrorLength" class="text-warning d-none">Debe tener al menos 4
                            caracteres</small>
                    </div>
                    <div class="col mb-0">
                        <label for="conPassword" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="conPassword" id="conPassword" class="form-control"
                            placeholder="Confirmar Contraseña" />
                        <small id="passwordError" class="text-danger d-none">Las contraseñas no
                            coinciden</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" disabled id="btnActualizar" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

</html>
