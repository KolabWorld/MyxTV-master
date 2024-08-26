<?php

namespace App\Exports;

use App\Models\ProductSizeGuide;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductSizeGuideExport implements FromCollection, WithMapping, WithHeadings
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
        $productSizeGuide = ProductSizeGuide::orderBy('id', 'DESC');

        if ($this->request->search) {
            $productSizeGuide->where('title', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->status) {
            $productSizeGuide->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $productSizeGuide->where('designer_id', $this->request->designer_id);
        }
        
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $productSizeGuide->whereIn('id',$filter_ids);
        }
        

        $productSizeGuide = $productSizeGuide->get();

        return $productSizeGuide;
    }

    public function map($productSizeGuide): array
    {

        return [
            ucfirst($productSizeGuide->status),
            $productSizeGuide->title,
            dateFormat($productSizeGuide->created_at),
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