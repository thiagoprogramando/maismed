@extends('app.layout')
@section('title') Calendário @endsection
@section('conteudo')

    <style>
        #calendar {
            max-width: 1100px !important;
            margin: 0 auto !important;

            background-color: #ffffff !important;

            padding: 5%;
        }

        #calendar .fc-event-title{
            font-size: 10px;
        }
    </style>

    <div class="pagetitle">
        <h1>Calendário</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('app') }}">Calendário</a></li>
                <li class="breadcrumb-item active">Calendário</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle p-2 w-25" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if($unit_start) {{ $unit_start->name }} @else Sem Unidade @endif</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($units_extend as $unit)
                            <a class="dropdown-item" href="{{ route('app') }}?id_unit={{ $unit->id }}">{{ $unit->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div id='calendar'></div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('app') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Filtrar dados da pesquisa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 mb-1">
                                <div class="form-floating">
                                    <select name="turn" class="form-select" id="floatingTurn">
                                        <option selected value="">Horário:</option>
                                        <option value="1">Diurno</option>
                                        <option value="2">Noturno</option>
                                    </select>
                                    <label for="floatingTurn">Horário</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-1">
                                <div class="form-floating">
                                    <select name="id_user" class="form-select" id="floatingUser">
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
                                    <select name="id_unit" class="form-select" id="floatingUnit">
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

    <script src='{{ asset('dashboard/js/fullcalendar/dist/index.global.min.js') }}'></script>
    <script src='{{ asset('dashboard/js/fullcalendar/dist/core/locales-all.global.min.js') }}'></script>
    <script src="{{ asset('dashboard/js/calendar.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var events = [
                @foreach($events as $event)
                    {
                        'id'    : '{{ $event->id }}',
                        'title' : "{{ $event->user->firstName() }} | {{ $event->situationLabel() }}",
                        'start' : '{{ $event->date_schedule }}',
                        'color' : '{{ $event->turn == 1 ? "#A8A8A8" : "#ff6961" }}'
                    },
                @endforeach
            ];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today,filtros',
                    center: 'title',
                    right: 'pdfPrint'
                },
                initialDate: new Date().toISOString().slice(0, 10),
                locale: 'pt-br',
                navLinks: false,
                selectable: {{ Auth::user()->type == 3 ? 'false' : 'true' }},
                selectMirror: true,
                eventOrder: false,
                select: function(arg) {
                    Swal.fire({
                        title: 'Adicionar Evento',
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Cadastrar',
                        confirmButtonColor: '#008000',
                        cancelButtonText: 'Cancelar',
                        cancelButtonColor: '#ff0000',
                        html:
                            '<div class="row w-100">' +
                                '<div class="col-12 col-md-12 col-lg-12 mb-1">' +
                                    '<div class="form-floating"> <input type="date" name="date_schedule" id="swal-date" class="form-control" value="' + arg.startStr + '" placeholder="Escolha uma data:" required><label for="swal-date">Escolha uma data:</label> </div>' +
                                '</div>' +
                                
                                '<div class="col-12 col-md-12 col-lg-12 mb-1">' +
                                    '<div class="form-floating">' +
                                        '<select id="swal-turn" class="form-select"> <option value="1">Diurno</option> <option value="2">Noturno</option> </select>' +
                                        '<label for="swal-turn">Horário</label>' +
                                    '</div>' +
                                '</div>' +

                                '<div class="col-12 col-md-12 col-lg-12 mb-2">' +
                                    '<select id="swal-user" placeholder="Colaborador(a)">' +
                                        '<option value="" selected>Colaborador(a)</option>' +
                                        '@foreach($users as $user)' +
                                            '<option value="{{ $user->id }}">{{ $user->firstName() }}</option>' +
                                        '@endforeach' +
                                    '</select>' +
                                '</div>' +

                                '<div class="col-12 col-md-12 col-lg-12 mb-2">' +
                                    '<select id="swal-unit" placeholder="Unidade">' +
                                        '<option value="" selected>Unidade</option>' +
                                        '@foreach($units as $unit)' +
                                            '<option value="{{ $unit->id }}">{{ $unit->name }}</option>' +
                                        '@endforeach' +
                                    '</select>' +
                                '</div>' +

                                '<div class="col-12 col-md-12 col-lg-12 mb-1">' +
                                    '<div class="form-floating">' +
                                        '<select id="swal-situation" class="form-select">' +
                                                '<option selected value="">Situação:</option>' +
                                                '<option value="1">À Vista</option>' +
                                                '<option value="0">Pendente</option>' +
                                        '</select>' +
                                        '<label for="swal-situation">Situação</label>' +
                                    '</div>' +
                                '</div>' +

                                '<div class="col-12 col-md-12 col-lg-12 mb-1">' +
                                    '<div class="form-floating">' +
                                        '<textarea name="observation" class="form-control" placeholder="Address" id="floatingObservation" style="height: 100px;"></textarea>' +
                                        '<label for="floatingObservation">Observações</label>' +
                                    '</div>' +
                                '</div>' +
                            '</div>',
                        focusConfirm: false,
                        preConfirm: () => {
                            return {
                                date_schedule   : document.getElementById('swal-date').value,
                                turn            : document.getElementById('swal-turn').value,
                                name_user       : document.getElementById('swal-user').options[document.getElementById('swal-user').selectedIndex].text,
                                id_user         : document.getElementById('swal-user').value,
                                name_unit       : document.getElementById('swal-unit').options[document.getElementById('swal-unit').selectedIndex].text,
                                id_unit         : document.getElementById('swal-unit').value,
                                situation   : document.getElementById('swal-situation').value,
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const addEventPromise = createEvent(result.value);
                            addEventPromise.then(data => {
                                calendar.addEvent({
                                    id: data.id,
                                    title: result.value.situation == 1 ? result.value.name_user + '| ✔'  : result.value.name_user,
                                    color: result.value.turn == 1 ? '#A8A8A8' : '#ff6961',
                                    start: result.value.date_schedule,
                                    allDay: true
                                });
                            }).catch(error => {
                                Swal.fire(
                                    'Atenção!',
                                    'O evento não foi cadastrado, tente novamente!',
                                    'info'
                                );
                            });
                        }
                    });

                    new TomSelect("#swal-user",{
                        create: false,
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });

                    new TomSelect("#swal-unit",{
                        create: false,
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });

                    calendar.unselect();
                },
                eventClick: function(arg) {
                    Swal.fire({
                        title: 'Excluir Evento',
                        text: 'Você tem certeza que deseja excluir este evento?',
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: 'Excluir',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#008000',
                        cancelButtonColor: '#ff0000',
                        denyButtonText: 'Editar',
                        denyButtonColor: '#ffc107'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            const addEventPromise = deleteEvent(arg.event.id);
                            addEventPromise.then(data => {
                                arg.event.remove();
                            }).catch(error => {
                                Swal.fire(
                                    'Excluído!',
                                    'O evento foi excluído com sucesso.',
                                    'success'
                                );
                            });
                        } else if (result.isDenied) {
                            window.open('{{ env("APP_URL") }}view-event/' + arg.event.id, '_blank');
                        }
                    });
                },
                editable: true,
                dayMaxEvents: false,
                events: events
            });

            calendar.render();

            $('.fc-filtros-button').html('Filtros');
            
            $('.fc-filtros-button').attr('data-bs-toggle', 'modal').attr('data-bs-target', '#filterModal');
            $('.fc-pdfPrint-button').html('PDF');
            $('.fc-pdfPrint-button').attr('id', 'calendario');
        });

        function createEvent(params) {

            var requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            };

            return fetch("{{ env('APP_URL') }}api/add-event", requestOptions)
                .then(response => {
                    if (!response.ok) {
                        return false;
                    }
                   
                    return response.json();
                })
                .catch(error => {
                    return false;
                });
        }

        function deleteEvent(id) {

            var params = { 
                id: id 
            };

            var requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            };

            return fetch("{{ env('APP_URL') }}api/del-event", requestOptions)
                .then(response => {
                    if (!response.ok) {
                        return false;
                    }
                   
                    return response.json();
                })
                .catch(error => {
                    return false;
                });
        }

        $(document).on('click', '#calendario', function() {

            var url = "{{ env('APP_URL') }}api/graph-calendar/?";

            var urlParams = new URLSearchParams(window.location.search);
            var id_unit = urlParams.get('id_unit');
            if (id_unit) {
                url += 'id_unit=' + id_unit + '&';
            }

            var id_unit = "{{ $unit_start->id }}";
            if(id_unit) {
                url += 'id_unit=' + id_unit + '&';
            }

            var id_user = urlParams.get('id_user');
            if (id_user) {
                url += 'id_user=' + id_user;
            }

            window.open(url, '_blank');
        });

    </script>
@endsection