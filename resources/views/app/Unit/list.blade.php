@extends('app.layout')
@section('title') Gestão de Unidades @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Gestão de Unidades</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Gestão de Unidades</li>
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
                        <form action="{{ route('list-unit') }}" method="GET">
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
                                            <input type="text" name="city" class="form-control" id="floatingCity" placeholder="Cidade:">
                                            <label for="floatingCity">Cidade:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="state" class="form-control" id="floatingState" placeholder="Estado:">
                                            <label for="floatingState">Estado:</label>
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
                        <form action="{{ route('create-unit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Cadastrar unidade no sistema</h5>
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
                                            <input type="text" name="city" class="form-control" id="floatingCity" placeholder="Cidade:">
                                            <label for="floatingCity">Cidade:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <input type="text" name="state" class="form-control" id="floatingState" placeholder="Estado:">
                                            <label for="floatingState">Estado:</label>
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
                    <h5 class="card-title">Unidades</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cidade - Estado</th>
                                    <th class="text-center" scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <th scope="row">{{ $unit->id }}</th>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->city }} - {{ $unit->state }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('delete-unit') }}" method="POST" class="delete">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $unit->id }}">
                                                <a href="{{ env('APP_URL') }}api/graph-calendar?id_unit={{ $unit->id }}" target="_blank" class="btn btn-success text-light"><i class="bi bi-calendar-check"></i></a>
                                                <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#updateModal{{ $unit->id }}"><i class="bi bi-arrow-up-right-circle"></i></button>
                                                @if(Auth::user()->type == 1) <button type="submit" class="btn btn-danger text-light"><i class="bi bi-trash"></i></button> @endif
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateModal{{ $unit->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('update-unit') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar dados</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <input type="hidden" name="id" value="{{ $unit->id }}">
                                                            
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome:" value="{{ $unit->name }}">
                                                                    <label for="floatingName">Nome:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="text" name="city" class="form-control" id="floatingCity" placeholder="Cidade:" value="{{ $unit->city }}">
                                                                    <label for="floatingCity">Cidade:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="text" name="state" class="form-control" id="floatingState" placeholder="Estado:" value="{{ $unit->state }}">
                                                                    <label for="floatingState">Estado:</label>
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