<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithColumnFormatting, WithCustomValueBinder
{
    private $customer_service;
    private $param;

    public function __construct($param, $customer_service) 
    {
        $this->customer_service = $customer_service;
        $this->param = $param;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->customer_service->getAll(null, $this->param->all())->get();
    }

     /**
    * @var Invoice $invoice
    */
    public function map($data): array
    {
        $data->telfon_pembeli = $this->validateNumber($data->telfon_pembeli);

        return [
            $data->nama_pembeli,
            $data->telfon_pembeli,
            $data->kota_pembeli
        ];
    }
    
    private function validateNumber($number)
    {
        $new_format = substr($number, 0,1); //0

        if($new_format === '0')
        {
            $number = '62'.substr($number, 1);
        }

        return $number;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal('center');
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function columnWidths(): array
    {
        return [ 
            'A' => 60,'B' => 60, 'C' => 60      
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        
        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function headings(): array
    {
        return ['Nama Pelanggan','Nomor WA', 'Kota/Kabupaten'];
    }
}
