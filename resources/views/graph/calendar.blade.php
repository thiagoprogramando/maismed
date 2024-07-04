<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Calendário</title>

        <link href="{{ asset('dashboard/img/logo.png') }}" rel="icon">
        <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('dashboard/css/calendar.css') }}" rel="stylesheet">
    </head>
    <body>

        <div class="row">
            <div class="col-12 mb-2 header row">
                <div class="col-sm-12 col-lg-3">
                    <img class="w-25 ml-5 mb-2 mt-2" src="{{asset('dashboard/img/logo.png') }}">
                </div>
                <div class="col-sm-12 col-lg-9">
                    <h2 class="mt-2">
                        @if(!empty($unit))
                            {{ $unit->name }} - {{ $unit->city }} / {{ $unit->state }}<br>
                        @endif 
                    </h2> 
                </div>          
            </div>
            <div class="col-9 mb-2">
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

            <div class="col-3">
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
        </div>

        <a id="pdf-download-link" style="display:none;"></a>

        <script src="{{ asset('dashboard/js/jquery.js') }}"></script>
        <script src="{{ asset('dashboard/js/html2pdf.bundle.min.js') }}"></script>
        <script>
            // Supondo que a variável Blade month seja passada como uma variável JavaScript
            const bladeMonth = @json($month); // Ex: 7 para agosto
        
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = bladeMonth - 1; // Ajusta para o índice do mês (0-11)
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
                const eventDate = new Date(event.date_schedule + 'T00:00:00');
                const eventDay = eventDate.getDate();
                const eventMonth = eventDate.getMonth();
                const eventYear = eventDate.getFullYear();
        
                if (eventMonth === currentMonth && eventYear === currentYear) {
                    const dayIndex = eventDay + precedingDays - 1;
                    const dayElement = $('#calendar-body tr').eq(Math.floor(dayIndex / 7)).find('td').eq(dayIndex % 7);
                    dayElement.append(`<div class="event ${event.turn == 1 ? 'diurno' : 'noturno'}"> <div class="event"> ${event.user_first_name} </div> </div>`);
                }
            });
            
            @if(!empty($unit->name))
                var unitName = @json($unit->name);
            @else
                var unitName = 'Escala Médica';
            @endif
        
            function openPdf(pdfBlob) {
                const pdfUrl = URL.createObjectURL(pdfBlob);
                const pdfLink = document.getElementById('pdf-download-link');
                pdfLink.href = pdfUrl;
                pdfLink.download = unitName + '.pdf';
                pdfLink.click();
        
                // Abrir o PDF em uma nova janela ou aba
                window.location.replace(pdfUrl);
            }
        
            html2pdf()
            .from(document.body)
            .set({
                margin: 0.3,
                filename: unitName + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'cm', format: 'letter', orientation: 'landscape' } // Definindo formato e orientação
            })
            .toPdf()
            .get('pdf')
            .then(function (pdf) {
                const pdfBlob = pdf.output('blob');
                openPdf(pdfBlob);
            });
        </script>               
    </body>
</html>