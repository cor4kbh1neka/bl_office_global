<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DepoWdExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
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
            if($itemArray['status'] == 1){
                $itemArray['status'] = 'ACCEPTED';
            } else if($itemArray['status'] == 2){
                $itemArray['status'] = 'REJECTED';
            } else {
                $itemArray['status'] = '';
            }
            return $itemArray;
        });
    }

    public function headings(): array
    {
        return [
            'Username',
            'Referral',
            'Amount',
            'Keterangan',
            'Jenis',
            'Groupbank',
            'Bank',
            'Namarek',
            'Norek',
            'Mbank',
            'Mnamarek',
            'Mnorek',
            'Txnid',
            'Balance',
            'Status',
            'Approved By',
            'Created At',
            'Updated At',
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
            'C' => 20,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 25,
            'I' => 25,
            'J' => 20,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 20,
            'O' => 20,
            'P' => 20,
            'Q' => 30,
            'R' => 30,
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
