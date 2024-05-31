<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>@yield('title') - {{ env('APP_NAME') }}</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <link href="{{ asset('dashboard/img/logo.png') }}" rel="icon">

        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <link href="{{ asset('dashboard/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        <script src="{{ asset('dashboard/js/sweetalert2.js') }}"></script>
    </head>

    <body>

        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('app') }}" class="logo-min d-flex align-items-center">
                    <img src="{{ asset('dashboard/img/logo.png') }}">
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>

            <div class="search-bar">
                <form class="search-form d-flex align-items-center" method="GET" action="{{ route('search') }}">
                    <input type="text" name="search" placeholder="Pesquisar" title="Pesquisar">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div>

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">

                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle " href="#"><i class="bi bi-search"></i></a>
                    </li>

                    @php
                        $nameParts = explode(' ', Auth::user()->name);
                        $firstName = $nameParts[0];
                        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
                    @endphp
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <span class="dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{ $firstName }} {{ $lastName }}</h6>
                                <span>{{ Auth::user()->typeLabel() }}</span>
                            </li>
                            <li> <hr class="dropdown-divider"> </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile-user') }}">
                                    <i class="bi bi-person"></i>
                                    <span>Perfil</span>
                                </a>
                            </li>
                            <li> <hr class="dropdown-divider"> </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sair</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('app') }}"> <i class="bi bi-calendar-event"></i> <span>Calendário</span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-shop-window"></i><span>Unidades</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        @foreach ($units_extend as $unit)
                            <li><a href="{{ route('app') }}?id_unit={{ $unit->id }}"> <i class="bi bi-circle"></i><span>{{ $unit->name }}</span> </a></li>
                        @endforeach
                    </ul>
                </li>

                @if(Auth::user()->type == 1)
                    <li class="nav-heading">Configurações</li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('list-event') }}"><i class="bi bi-bookmark-plus-fill"></i><span>Eventos</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('list-unit') }}"><i class="bi bi-shop-window"></i><span>Unidade</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#forms-user" data-bs-toggle="collapse" href="#">
                            <i class="bi bi-person"></i><span>Usuários</span><i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="forms-user" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            @if(Auth::user()->type == 1)
                                <li><a href="{{ route('list-user', ['type' => 1]) }}"> <i class="bi bi-circle"></i><span>Administradores</span> </a></li>
                            @endif
                            <li><a href="{{ route('list-user', ['type' => 2]) }}"> <i class="bi bi-circle"></i><span>Supervisores</span> </a></li>
                            <li><a href="{{ route('list-user', ['type' => 3]) }}"> <i class="bi bi-circle"></i><span>Colaboradores</span> </a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i><span>Sair</span></a>
                </li>
            </ul>

        </aside>

        <main id="main" class="main">
            @yield('conteudo')
        </main>

        <footer id="footer" class="footer">
            <div class="copyright"> &copy; Copyright <strong><span>{{ env('APP_NAME') }}</span></strong>. Todos os direitos reservados </div>
            <div class="credits">
                Desenvolvido por <a href="https://ifuture.cloud/">Ifuture.cloud</a>
            </div>
        </footer>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dashboard/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('dashboard/js/main.js') }}"></script>
        <script>

            @if(session('error'))
                Swal.fire({
                    title: 'Erro!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    timer: 2000
                })
            @endif
            
            @if(session('success'))
                Swal.fire({
                    title: 'Sucesso!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 2000
                })
            @endif

            document.addEventListener('DOMContentLoaded', function () {

                const deleteForms = document.querySelectorAll('form.delete');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function (event) {
                        
                        event.preventDefault();
                        Swal.fire({
                            title: 'Tem certeza?',
                            text: 'Você realmente deseja excluir este registro?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sim',
                            confirmButtonColor: '#008000',
                            cancelButtonText: 'Não',
                            cancelButtonColor: '#FF0000',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                let inputs = document.querySelectorAll('input[type="text"][oninput="mascaraReal(this)"]');
                inputs.forEach(function(input) {
                    mascaraReal(input);
                });
            });
        </script>

    </body>
</html>