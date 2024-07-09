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

class HistoryTransaksiExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            $itemArray = $item->toArray();
            unset($itemArray['id']); // Menghilangkan kolom "id"
            // Format ulang created_at dan updated_at
            if (isset($itemArray['created_at'])) {
                $itemArray['created_at'] = \Carbon\Carbon::parse($itemArray['created_at'])->format('Y-m-d H:i:s');
            }

            if (isset($itemArray['updated_at'])) {
                $itemArray['updated_at'] = \Carbon\Carbon::parse($itemArray['updated_at'])->format('Y-m-d H:i:s');
            }
            return $itemArray;
        });
    }

    public function headings(): array
    {
        return [
            "Username",
            "#",
            "Invoice",
            "Game",
            "Game",
            "Keterangan",
            "Debit",
            "Kredit",
            "Balance",
            "Urutan",
            "Created",
            "Updated",
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
            'I' => 25,
            'J' => 20,
            'K' => 25,
            'L' => 25,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:R' . (count($this->data) + 1);
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
