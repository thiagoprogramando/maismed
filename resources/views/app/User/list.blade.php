@extends('app.layout')
@section('title') Gestão de Pessoas @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Gestão de Pessoas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Gestão de Pessoas</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-12">

            <div class="btn-group mb-3" role="group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filtros</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createModal">Cadastrar</button>
                <button type="button" class="btn btn-outline-primary">Excel</button>
            </div>

            <div class="modal fade" id="filterModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('list-user') }}" method="GET">
                            <div class="modal-header">
                                <h5 class="modal-title">Filtrar dados da pesquisa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome:">
                                            <label for="floatingName">Nome:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email:">
                                            <label for="floatingEmail">Email:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="crm" class="form-control" id="floatingCrm" placeholder="CRM:">
                                            <label for="floatingCrm">CRM:</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success">Consultar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="createModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('create-user') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Cadastrar usuário no sistema</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome:" required>
                                            <label for="floatingName">Nome:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="number" name="cpfcnpj" class="form-control" id="floatingCpfCNpj" placeholder="CPF/CNPJ:">
                                            <label for="floatingCpfCNpj">CPF/CNPJ:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="crm" class="form-control" id="floatingCrm" placeholder="CRM:">
                                            <label for="floatingCrm">CRM:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email:" required>
                                            <label for="floatingEmail">Email:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <select name="type" class="form-select" id="floatingType" required>
                                                <option selected value="2">Tipo:</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Supervisor</option>
                                                <option value="3">Médico</option>
                                            </select>
                                            <label for="floatingType">Tipo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card p-5">
                <div class="card-body">
                    <h5 class="card-title">Pessoas</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">CRM</th>
                                    <th class="text-center" scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->cpfcnpj }}</td>
                                        <td>{{ $user->typeLabel() }}</td>
                                        <td>{{ $user->crm }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('delete-user') }}" method="POST" class="delete">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <a href="{{ env('APP_URL') }}api/graph-calendar?id_user={{ $user->id }}" target="_blank" class="btn btn-success text-light"><i class="bi bi-calendar-check"></i></a>
                                                <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#updateModal{{ $user->id }}"><i class="bi bi-arrow-up-right-circle"></i></button>
                                                <button type="submit" class="btn btn-danger text-light"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('update-user') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar dados</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                                            
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome:" value="{{ $user->name }}">
                                                                    <label for="floatingName">Nome:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email:" value="{{ $user->email }}">
                                                                    <label for="floatingEmail">Email:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="text" name="crm" class="form-control" id="floatingCRM" placeholder="CRM:" value="{{ $user->crm }}">
                                                                    <label for="floatingCRM">CRM:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <select name="type" class="form-select" id="floatingType">
                                                                        <option selected value="{{ $user->type }}">Tipo:</option>
                                                                        <option value="1">Administrador</option>
                                                                        <option value="2">Supervisor</option>
                                                                        <option value="3">Médico</option>
                                                                    </select>
                                                                    <label for="floatingType">Tipo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-success">Atualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection