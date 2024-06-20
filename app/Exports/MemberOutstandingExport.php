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

class MemberOutstandingExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
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

            if (isset($itemArray['created_at'])) {
                $itemArray['created_at'] = \Carbon\Carbon::parse($itemArray['created_at'])->format('Y-m-d H:i:s');
            }


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
            "Nominal Bet (IDR)",
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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:F' . (count($this->data) + 1);
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
