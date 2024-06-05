<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReferralExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $key) {
            $itemArray = (array) $item; // Convert stdClass object to array
            unset($itemArray['id']); // Remove the "id" column

            $itemArray = array_values($itemArray); // Reindex array values
            array_unshift($itemArray, (int)($key + 1)); // Add serial number at the beginning
            return $itemArray;
        });
    }

    public function headings(): array
    {
        return [
            ["#", "upline", "total downline", "deposit status", "", "aktif status", "", "bonus referral (IDR)"],
            ["", "", "", "deposit", "belum deposit", "aktif", "tidak aktif", ""]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cells for headers
                $event->sheet->getDelegate()->mergeCells('A1:A2'); // rowspan for #
                $event->sheet->getDelegate()->mergeCells('B1:B2'); // rowspan for upline
                $event->sheet->getDelegate()->mergeCells('C1:C2'); // rowspan for total downline
                $event->sheet->getDelegate()->mergeCells('D1:E1'); // colspan for deposit status
                $event->sheet->getDelegate()->mergeCells('F1:G1'); // colspan for aktif status
                $event->sheet->getDelegate()->mergeCells('H1:H2'); // rowspan for bonus referral

                // Apply border styles
                $cellRange = 'A1:H' . (count($this->data) + 2); // +2 for the two header rows
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Center align text in headers
                $event->sheet->getDelegate()->getStyle('A1:H2')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A1:H2')->getAlignment()->setVertical('center');
            },
        ];
    }
}
