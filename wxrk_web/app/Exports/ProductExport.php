<?php

namespace App\Exports;

use App\Models\Product;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection, WithMapping, WithHeadings
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
        $products = Product::with('subCategories')->orderBy('id', 'DESC');

        if ($this->request->search) {
            $products->where('title', 'like', '%' . $this->request->search . '%');
        }
        if ($this->request->status) {
            $products->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $products->where('designer_id', $this->request->designer_id);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $products->whereIn('id',$filter_ids);
        }

        $products = $products->get();

        return $products;
    }

    public function map($products): array
    {
        $subCategories = '';
        foreach ($products->subCategories as $key => $value) {
            if ($key > 0) {
                $subCategories = $subCategories . ',' . $value->name;
            } else {
                $subCategories = $subCategories . '' . $value->name;
            }
        }

        return [
            $products->title,
            $products->code,
            '#NA',
            $subCategories,
            $products->avg_lead_time,
            $products->short_description,
            $products->long_description,
            '#NA',
        ];
    }

    public function headings(): array
    {
        $columns = array('Product Name', 'Product Code', 'Categories', 'Sub Categories', 'Avg Lead Time', 'Short Description', 'Long Description', 'Amount');

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