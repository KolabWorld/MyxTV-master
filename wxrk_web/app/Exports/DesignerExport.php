<?php

namespace App\Exports;

use App\Models\Designer;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DesignerExport implements FromCollection, WithMapping, WithHeadings
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
        $designers = Designer::orderBy('id', 'DESC');

        if ($this->request->search) {
            $designers->where('name', $this->request->search);
        }

        if ($this->request->status) {
            $designers->where('status', $this->request->status);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $designers->whereIn('id',$filter_ids);
        }

        $designers = $designers->get();

        return $designers;
    }

    public function map($designers): array
    {

        return [
            $designers->status,
            $designers->designer_id,
            $designers->name,
            $designers->email,
            $designers->avg_lead_time ? $designers->avg_lead_time . ' days' : '-',
            '#NA',
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'Designer ID', 'Designer Name', 'Contact', 'Avg. Time', 'Total Earned');

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