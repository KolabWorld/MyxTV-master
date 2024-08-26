<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $customers = User::with('address')->orderBy('id', 'DESC');

        if ($this->request->search) {
            $customers->where('name', $this->request->search);
        }

        if ($this->request->status) {
            $customers->where('status', $this->request->status);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $customers->whereIn('id',$filter_ids);
        }

        $customers = $customers->get();

        return $customers;
    }

    public function map($customers): array
    {
        if ($customers->address) {
            $address = $customers->address->country ? $customers->address->country->name : '-';
        } else {
            $address = '-';
        }

        return [
            $customers->status,
            'CU000' . $customers->id,
            $customers->name,
            $customers->email,
            $address,
            '$0',
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'Customer ID', 'Customer Name', 'Contact', 'Location', 'Total Spent');

        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}