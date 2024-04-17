@extends('app.layout')
@section('title') Perfil @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Perfil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mantenha seus dados atualizados.</h5>

                    <form action="{{ route('update-user') }}" method="POST" class="row g-3">
                        @csrf

                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                        <div class="col-12 col-md-12 col-lg-12 mb-1">
                            <div class="form-floating">
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" id="floatingName" placeholder="Nome:">
                                <label for="floatingName">Nome:</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-1">
                            <div class="form-floating">
                                <input type="text" name="cpfcnpj" value="{{ Auth::user()->cpfcnpj }}" class="form-control" id="floatingCpfcnpj" placeholder="CPF ou CNPJ:">
                                <label for="floatingCpfcnpj">CPF ou CNPJ:</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-1">
                            <div class="form-floating">
                                <input type="text" name="crm" value="{{ Auth::user()->crm }}" class="form-control" id="floatingCrm" placeholder="CRM:">
                                <label for="floatingCrm">CRM:</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6 mb-1">
                            <div class="form-floating">
                                <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" id="floatingEmail" placeholder="Email:">
                                <label for="floatingEmail">Email:</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-1">
                            <div class="form-floating">
                                <input type="text" name="password" class="form-control" id="floatingSenha" placeholder="Senha:">
                                <label for="floatingSenha">Senha:</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3 offset-md-9 offset-lg-9 d-grid gap-2 mb-1">
                            <button type="submit" class="btn btn-outline-success rounded-pill" type="button">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection