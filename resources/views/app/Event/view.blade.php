@extends('app.layout')
@section('title') Evento: {{ $event->date_schedule }} @endsection
@section('conteudo')

<div class="pagetitle">
    <h1>Evento: {{ $event->date_schedule }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('app') }}">Escritório</a></li>
            <li class="breadcrumb-item active">Evento: {{ $event->date_schedule }}</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-12">

            <div class="card p-5">
                <div class="card-body">
                    <h5 class="card-title">Dados do Evento</h5>
                    
                    <form id="eventForm" action="{{ route('update-event') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $event->id }}">

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                <div class="form-floating">
                                    <input type="date" name="date_schedule" class="form-control" id="floatingDateSchedule" placeholder="Escolha uma data:" value="{{ $event->date_schedule }}">
                                    <label for="floatingDateSchedule">Escolha uma data:</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                <div class="form-floating">
                                    <select name="turn" class="form-select" id="floatingTurn" required>
                                        <option selected value="{{ $event->turn }}">@if(!empty($event->turn)) {{ $event->turnLabel() }} @else Horário: @endif</option>
                                        <option value="1">Diurno</option>
                                        <option value="2">Noturno</option>
                                    </select>
                                    <label for="floatingTurn">Tipo</label>
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
                            <div class="col-12 col-md-6 col-lg-6 offset-md-6 offset-lg-6 mt-2">
                                <button type="button" id="delete" class="btn btn-danger" data-bs-dismiss="modal">Excluir</button>
                                <button type="button" id="update" class="btn btn-success">Atualizar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('delete').addEventListener('click', function() {
            Swal.fire({
                title: 'Excluir Evento',
                text: 'Você tem certeza que deseja excluir este evento?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#008000',
                cancelButtonColor: '#ff0000',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('eventForm').action = "{{ route('delete-event') }}";
                    document.getElementById('eventForm').submit();
                }
            });
        });

        document.getElementById('update').addEventListener('click', function() {
            Swal.fire({
                title: 'Atualizar Evento',
                text: 'Você tem certeza que deseja atualizar este evento?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sim, atualizar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#008000',
                cancelButtonColor: '#ff0000',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('eventForm').submit();
                }
            });
        });
    });
</script>

@endsection