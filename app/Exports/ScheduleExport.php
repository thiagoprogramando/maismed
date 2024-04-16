<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Carbon\Carbon;

class ScheduleExport implements FromCollection, WithHeadings, WithStyles {

    protected $id;
    protected $month;
    protected $year;

    public function __construct($id) {

        $this->id = $id;
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
    }

    public function collection()
    {
        $calendar = [];

        // Adiciona o cabeçalho do mês e do ano
        $calendar[] = ['Calendário de ' . Carbon::createFromDate($this->year, $this->month, 1)->format('F Y')];

        // Adiciona os dias da semana como cabeçalhos
        $calendar[] = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];

        // Obtém o primeiro dia do mês
        $firstDayOfMonth = Carbon::createFromDate($this->year, $this->month, 1);

        // Loop através de cada semana do mês
        while ($firstDayOfMonth->month == $this->month) {
            $week = [];

            // Loop através de cada dia da semana
            for ($dayOfWeek = Carbon::MONDAY; $dayOfWeek <= Carbon::SUNDAY; $dayOfWeek++) {
                // Verifica se o dia pertence ao mês atual
                if ($firstDayOfMonth->month == $this->month) {
                    $events = Schedule::where('day', $firstDayOfMonth->day)
                        ->where('month', $this->month)
                        ->where('year', $this->year)
                        ->get();

                    // Adiciona o dia e os eventos à semana
                    $week[] = [
                        'date' => $firstDayOfMonth->format('d/m/Y'),
                        'events' => $events
                    ];
                } else {
                    // Se o dia não pertencer ao mês atual, adiciona um espaço em branco
                    $week[] = '';
                }

                // Avança para o próximo dia
                $firstDayOfMonth->addDay();
            }

            // Adiciona a semana ao calendário
            $calendar[] = $week;
        }

        return collect($calendar);
    }

    public function headings(): array {
        return [
            'Segunda',
            'Terça',
            'Quarta',
            'Quinta',
            'Sexta',
            'Sábado',
            'Domingo',
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '000000',
                ],
            ],
        ]);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A2:' . $lastColumn . $lastRow;
        $sheet->getStyle($range)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00008B',
                ],
            ],
            'font' => [
                'color' => ['rgb' => 'FFFFFF'],
            ],
        ]);
    }

}
