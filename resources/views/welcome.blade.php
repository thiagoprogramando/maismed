<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Acesso ao {{ env('APP_NAME') }}</title>

        <link href="{{ asset('dashboard/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('dashboard/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <link href="{{ asset('dashboard/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    </head>

    <body>
        <main>
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                <div class="d-flex justify-content-center py-4">
                                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                                        <img src="{{ asset('dashboard/img/logo.png') }}">
                                        <span class="d-none d-lg-block">{{ env('APP_NAME') }}</span>
                                    </a>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">{{ env('APP_NAME') }}</h5>
                                            <p class="text-center small">{{ env('APP_DESCRIPTION') }}</p>
                                        </div>

                                        <form class="row g-3 needs-validation" action="{{ route('logon') }}" method="POST">
                                            @csrf
                                            <div class="col-12">
                                                <input type="email" name="email" placeholder="Email:" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <input type="password" name="password" placeholder="Senha:" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="submit">Acessar</button>
                                            </div>
                                            <div class="col-12 text-center">
                                                <p class="small mb-0">V 0.0.1</p>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="credits">
                                    Desenvolvido por <a href="https://ifuture.cloud/">IFUTURE</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dashboard/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('dashboard/js/main.js') }}"></script>

    </body>
</html>