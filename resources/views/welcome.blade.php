<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Escala - {{ env('APP_NAME') }}</title>

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
        
        <header id="header" class="header bg-dark fixed-top d-flex align-items-center">
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">

                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <span class="dropdown-toggle ps-2 text-white">Opções</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>Outras opções</h6>
                                
                            </li>
                            <li> <hr class="dropdown-divider"> </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                                    <i class="bi bi-person"></i>
                                    <span>Acesso</span>
                                </a>
                            </li>
                            <li> <hr class="dropdown-divider"> </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="https://maismeds.com.br/">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>MaisMed</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <main class="container mt-5">
            <div class="row">

                <div class="col-12 col-md-12 col-lg-12 mt-5">
                    <div class="text-center">
                        <img src="{{ asset('dashboard/img/logo.png') }}" class="logo-img" alt="Logo">
                    </div>
                    <p>Escala Médicas</p>
                    <hr>
                </div>

                <div class="col-12 col-md-12 col-lg-12">
                    <form action="{{ route('graph-calendar') }}" class="row">
                        <div class="col-4">
                            <select id="swal-unit" name="id_unit" placeholder="Unidade">
                                <option value="" selected>Unidade</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 row">
                            <div class="col-6">
                                <select name="month" class="form-control" placeholder="Mês">
                                    <option value="{{ date('m') }}" selected>Mês</option>
                                    <option value="1">janeiro</option>
                                    <option value="2">Fevereiro</option>
                                    <option value="3">Março</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Maio</option>
                                    <option value="6">Junho</option>
                                    <option value="7">Julho</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" name="year" class="form-control" placeholder="Ano (Ex: 2024):" required>
                            </div>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-outline-primary">Ver Escala</button>
                        </div>
                    </form>
                </div>

            </div>
        </main>

        <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dashboard/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('dashboard/js/main.js') }}"></script>
        <script>
            new TomSelect("#swal-unit",{
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>

    </body>
</html>