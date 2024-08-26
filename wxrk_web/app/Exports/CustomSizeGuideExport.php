<?php

namespace App\Exports;

use App\Models\ProductCustomSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomSizeGuideExport implements FromCollection, WithMapping, WithHeadings
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
        $productCustomSize = ProductCustomSize::orderBy('id', 'DESC');

        if ($this->request->search) {
            $productCustomSize->where('title', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->status) {
            $productCustomSize->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $productCustomSize->where('designer_id', $this->request->designer_id);
        }
        
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $productCustomSize->whereIn('id',$filter_ids);
        }
        

        $productCustomSize = $productCustomSize->get();

        return $productCustomSize;
    }

    public function map($productCustomSize): array
    {

        return [
            ucfirst($productCustomSize->status),
            $productCustomSize->title,
            dateFormat($productCustomSize->created_at),
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'Title', 'Date');

        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}