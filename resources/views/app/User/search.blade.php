@extends('app.layout')
@section('title') Pesquisa: {{ $search }} @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Pesquisa: {{ $search }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Pesquisa: {{ $search }}</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">

        <div class="col-xxl-12 col-md-12 mb-3">
            <div class="card p-5">
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
                                            <form action="{{ route('update-event') }}" method="POST" enctype="multipart/form-data">
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

        <div class="col-xxl-12 col-md-12 mb-3">
            <div class="card p-5">
                <h5 class="card-title">Unidades</h5>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Cidade - Estado</th>
                                <th class="text-center" scope="col">Logo</th>
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
                                        <div class="post-item clearfix">
                                            <img src="{{ asset('storage/' . $unit->file) }}">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('delete-unit') }}" method="POST" class="delete">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $unit->id }}">
                                            <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#updateModal{{ $unit->id }}"><i class="bi bi-arrow-up-right-circle"></i></button>
                                            <button type="submit" class="btn btn-danger text-light"><i class="bi bi-trash"></i></button>
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
                                                        <div class="col-12 col-md-12 col-lg-12 mb-1">
                                                            <input class="form-control" type="file" name="file">
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

        <div class="col-xxl-12 col-md-12 mb-3">
            <div class="card p-5">
                <h5 class="card-title">Usuários</h5>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nome</th>
                                <th scope="col">CRM</th>
                                <th class="text-center" scope="col">T. Eventos</th>
                                <th class="text-center" scope="col">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->crm }}</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">
                                        <form action="{{ route('delete-user') }}" method="POST" class="delete">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
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
                                                                    <option value="2">Comum</option>
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
</section>

@endsection