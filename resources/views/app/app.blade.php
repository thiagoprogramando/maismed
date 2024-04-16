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
            font-size: 8px;
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
    <script src="{{ asset('dashboard/js/jquery.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var events = [
                @foreach($events as $event)
                    {
                        'id'    : '{{ $event->id }}',
                        'title' : '{{ $event->turnLabel() }} | {{ $event->user->name }}',
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
                selectable: true,
                selectMirror: true,
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

                                '<div class="col-12 col-md-6 col-lg-6 mb-1">' +
                                    '<div class="form-floating">' +
                                        '<select id="swal-user" class="form-select">' +
                                            '@foreach($users as $user)' +
                                                '<option value="{{ $user->id }}">{{ $user->name }}</option>' +
                                            '@endforeach' +
                                        '</select>' +
                                        '<label for="swal-user">Usuário</label>' +
                                    '</div>' +
                                '</div>' +

                                '<div class="col-12 col-md-6 col-lg-6 mb-1">' +
                                    '<div class="form-floating">' +
                                        '<select id="swal-unit" class="form-select">' +
                                            '@foreach($units as $unit)' +
                                                '<option value="{{ $unit->id }}">{{ $unit->name }}</option>' +
                                            '@endforeach' +
                                        '</select>' +
                                        '<label for="swal-unit">Unidades</label>' +
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
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            const addEventPromise = createEvent(result.value);
                            addEventPromise.then(data => {
                                calendar.addEvent({
                                    title: result.value.turn == 1 ? 'Diurno | ' + result.value.name_user : 'Noturno | ' + result.value.name_user,
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
                    calendar.unselect();
                },
                eventClick: function(arg) {
                    Swal.fire({
                        title: 'Excluir Evento',
                        text: 'Você tem certeza que deseja excluir este evento?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Excluir',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#008000',
                        cancelButtonColor: '#ff0000',
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

            var id_user = urlParams.get('id_user');
            if (id_user) {
                url += 'id_user=' + id_user;
            }

            window.open(url, '_blank');
        });

    </script>
@endsection