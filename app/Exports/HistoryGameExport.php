<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HistoryGameExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            if (is_array($item)) {
                return $item;
            }

            $itemArray = $item->toArray();
            unset($itemArray['id']); // Menghilangkan kolom "id"

            return $itemArray;
        });
    }

    public function headings(): array
    {
        return [
            "Username",
            "Tanggal",
            "Nomor Invoice",
            "Detail",
            "Odds Betingan",
            "Nominal Bet (IDR)",
            "Win/Loss(IDR)",
            "Status Betingan",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 15,
            'D' => 30,
            'E' => 10,
            'F' => 20,
            'G' => 20,
            'H' => 25,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:H' . (count($this->data) + 1);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }
}
