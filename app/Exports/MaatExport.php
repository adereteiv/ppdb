<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithColumnFormatting,
    WithEvents
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class MaatExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    protected $data;
    protected $styleRange;
    protected $headings;
    protected $columnWidths;
    protected $columnFormats;

    public function __construct($data, $styleRange, $headings, $columnWidths = [], $columnFormats = [])
    {
        $this->data = $data;
        $this->styleRange = $styleRange;
        $this->headings = $headings;
        $this->columnWidths = $columnWidths;
        $this->columnFormats = $columnFormats;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return $this->columnWidths;
    }

    public function columnFormats(): array
    {
        return $this->columnFormats;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle($this->styleRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEFEFEF'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
