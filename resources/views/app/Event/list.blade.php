@extends('app.layout')
@section('title') Gestão de Eventos @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Gestão de Eventos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Gestão de Eventos</li>
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
                        <form action="{{ route('list-event') }}" method="GET">
                            <div class="modal-header">
                                <h5 class="modal-title">Filtrar dados da pesquisa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <input type="date" name="date_schedule" class="form-control" id="floatingDateSchedule" placeholder="Escolha uma data:">
                                            <label for="floatingDateSchedule">Escolha uma data:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <select name="turn" class="form-select" id="floatingTurn" required>
                                                <option selected value="1">Horário:</option>
                                                <option value="1">Diurno</option>
                                                <option value="2">Noturno</option>
                                            </select>
                                            <label for="floatingTurn">Tipo</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <select name="id_user" class="form-select" id="floatingUser" required>
                                                <option selected value=" ">Usuário:</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingUser">Usuário</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <select name="id_unit" class="form-select" id="floatingUnit" required>
                                                <option selected value=" ">Unidade:</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingUnit">Unidades</label>
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
                        <form action="{{ route('create-event') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Cadastrar evento no sistema</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <input type="date" name="date_schedule" class="form-control" id="floatingDateSchedule" placeholder="Escolha uma data:" required>
                                            <label for="floatingDateSchedule">Escolha uma data:</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <select name="turn" class="form-select" id="floatingTurn" required>
                                                <option selected value="1">Horário:</option>
                                                <option value="1">Diurno</option>
                                                <option value="2">Noturno</option>
                                            </select>
                                            <label for="floatingTurn">Horário</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <select name="id_user" class="form-select" id="floatingUser" required>
                                                <option selected value=" ">Usuário:</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingUser">Usuário</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-1">
                                        <div class="form-floating">
                                            <select name="id_unit" class="form-select" id="floatingUnit" required>
                                                <option selected value=" ">Unidade:</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingUnit">Unidades</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <select name="situation" class="form-select" id="floatingUnit">
                                                <option selected value="">Situação:</option>
                                                <option value="Avista">Avista</option>
                                                <option value="Pendente">Pendente</option>
                                            </select>
                                            <label for="floatingUnit">Situação</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 mb-1">
                                        <div class="form-floating">
                                            <textarea name="observation" class="form-control" placeholder="Address" id="floatingObservation" style="height: 100px;"></textarea>
                                            <label for="floatingObservation">Observações</label>
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
                    <h5 class="card-title">Eventos</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Unidade</th>
                                    <th class="text-center" scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <th scope="row">{{ $event->id }}</th>
                                        <td>{{ \Carbon\Carbon::parse($event->date_schedule)->format('d/m/Y') }}</td>
                                        <td>{{ $event->turnLabel() }}</td>
                                        <td>{{ $event->user->name }}</td>
                                        <td>{{ $event->unit->name }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('delete-event') }}" method="POST" class="delete">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $event->id }}">
                                                <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#updateModal{{ $event->id }}"><i class="bi bi-arrow-up-right-circle"></i></button>
                                                <button type="submit" class="btn btn-danger text-light"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="updateModal{{ $event->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('update-event') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar dados</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <input type="hidden" name="id" value="{{ $event->id }}">
                                                            
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <input type="date" name="date_schedule" class="form-control" id="floatingDateSchedule" placeholder="Escolha uma data:" value="{{ $event->date_schedule }}" required>
                                                                    <label for="floatingDateSchedule">Escolha uma data:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <select name="turn" class="form-select" id="floatingTurn" required>
                                                                        <option selected value="{{ $event->turn }}">@if(!empty($event->turn)) {{ $event->turnLabel() }} @else Horário: @endif</option>
                                                                        <option value="1">Diurno</option>
                                                                        <option value="2">Noturno</option>
                                                                    </select>
                                                                    <label for="floatingTurn">Horário</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <select name="id_user" class="form-select" id="floatingUser" required>
                                                                        <option selected value="{{ $event->id_user }}">@if(!empty($event->id_user)) {{ $event->user->name }} @else Usuário: @endif</option>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="floatingUser">Usuário</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                                                <div class="form-floating">
                                                                    <select name="id_unit" class="form-select" id="floatingUnit" required>
                                                                        <option selected value="{{ $event->id_unit }}"> @if(!empty($event->id_unit)) {{ $event->unit->name }} @else Unidade: @endif</option>
                                                                        @foreach ($units as $unit)
                                                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label for="floatingUnit">Unidades</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <select name="situation" class="form-select" id="floatingUnit">
                                                                        <option selected value="{{ $event->situation }}">@if(!empty($event->situation)) {{ $event->situation }} @else Situação: @endif</option>
                                                                        <option value="Pago">Pago</option>
                                                                        <option value="Pendente">Pendente</option>
                                                                    </select>
                                                                    <label for="floatingUnit">Situação</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                                <div class="form-floating">
                                                                    <textarea name="observation" class="form-control" placeholder="Address" id="floatingObservation" style="height: 100px;">{{ $event->observation }}</textarea>
                                                                    <label for="floatingObservation">Observações</label>
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