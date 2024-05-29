<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Calendário</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                font-size: 8px;
            }
            td div {
                margin: 0;
                padding: 0;
                display: block;
            }
            .day {
                background-color: #140750;
                color: #ffffff;
                text-align: center;
                font-size: 10px;
            }

            .diurno {
                background-color: #A8A8A8;
                color: #ffffff;
                font-size: 10px;
            }

            .nortuno {
                background-color: #ff6961;
                color: #ffffff;
                font-size: 10px;
            }

            .event {
                border-bottom: 1px solid #DEE2E6;
                width: 100%;
            }
            .table-user {
                font-size: 10px;
            }
            .header {
                border-bottom: 1px solid #DEE2E6;
            }
        </style>
    </head>
    <body>

        <div class="row">
            <div class="col-12 mb-2 header text-center">
                <p class="mt-2">
                    @if(!empty($unit))
                        {{ $unit->name }} - {{ $unit->city }} / {{ $unit->state }}<br>
                    @endif 
                </p>                
            </div>
            <div class="col-8 mb-2">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">SEGUNDA</th>
                            <th scope="col">TERÇA</th>
                            <th scope="col">QUARTA</th>
                            <th scope="col">QUINTA</th>
                            <th scope="col">SEXTA</th>
                            <th scope="col">SÁBADO</th>
                            <th scope="col">DOMINGO</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body"></tbody>
                </table>
            </div>

            <div class="col-4">
                <table class="table table-bordered table-user">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">NOMES</th>
                            <th scope="col" class="text-center">CRM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">{{ $user->crm }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-12">
                <table class="table table-bordered mb-2">
                    <tbody>
                        <tr>
                            <td style="background-color: #A8A8A8; color: #ffffff;">DIURNO</td>
                            <td style="background-color: #ff6961; color: #ffffff;">NOTURNO</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
        <script>
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();
            const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const precedingDays = (firstDayOfMonth.getDay() + 6) % 7;
            const numRows = Math.ceil((precedingDays + daysInMonth) / 7);
        
            let calendarHTML = '';
            for (let i = 0; i < numRows; i++) {
                calendarHTML += '<tr>';
                for (let j = 0; j < 7; j++) {
                    const day = i * 7 + j - precedingDays + 1;
                    if (day > 0 && day <= daysInMonth) {
                        calendarHTML += `<td> <div class="day"> DIA ${day} </div> </td>`;
                    } else {
                        calendarHTML += '<td>&nbsp;</td>';
                    }
                }
                calendarHTML += '</tr>';
            }
        
            $('#calendar-body').html(calendarHTML);
        
            const events = @json($events);
            events.forEach(event => {
                const eventDate = new Date(event.date_schedule);
                const eventDay = eventDate.getDate();
                const eventMonth = eventDate.getMonth();
                const eventYear = eventDate.getFullYear();
        
                if (eventMonth === currentMonth && eventYear === currentYear) {
                    const dayIndex = eventDay + precedingDays;
                    const dayElement = $('#calendar-body tr').eq(Math.floor(dayIndex / 7)).find('td').eq(dayIndex % 7);
                    dayElement.append(`<div class="event ${event.turn == 1 ? 'diurno' : 'nortuno'}"> <div class="event"> ${event.user_first_name} </div> </div>`);
                }
            });
        
            // Gere o PDF da página
            html2pdf(document.body, {
                margin: 0.3,
                filename: 'calendario.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'cm', format: 'letter', orientation: 'landscape' }
            });
        </script>        
    </body>
</html>