<?php

namespace App\Exports;

use App\Helpers\ConstantHelper;
use App\Models\Designer;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AmbassadorExport implements FromCollection, WithMapping, WithHeadings
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
        $ambassadors = Designer::where('user_type', '=', ConstantHelper::TYPE_AMBASSADOR)->orderBy('id', 'DESC');

        if ($this->request->search) {
            $ambassadors->where('name', 'like', '%' . $this->request->search . '%');
        }
        if ($this->request->status) {
            $ambassadors->where('status', $this->request->status);
        }
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $ambassadors->whereIn('id',$filter_ids);
        }

        $ambassadors = $ambassadors->get();

        return $ambassadors;
    }

    public function map($ambassadors): array
    {

        return [
            $ambassadors->name,
            $ambassadors->ambassador_id,
            $ambassadors->status,
            $ambassadors->mobile,
            $ambassadors->email,
            $ambassadors->descriptions,
            '0$',
        ];
    }

    public function headings(): array
    {
        $columns = array('Ambassadors Name', 'Ambassadors ID', 'Status', 'Contact No', 'Email', 'Descriptions', 'Total Earned');

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