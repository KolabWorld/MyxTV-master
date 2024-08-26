<?php

namespace App\Exports;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeVariable;
use App\Models\Payout;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ProductAttributeExport implements FromArray, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function array() : array
    {
        
        $productAttribute = ProductAttribute::orderBy('id', 'DESC');

        if ($this->request->search) {
            $productAttribute->where('name', 'like', '%' . $this->request->search . '%');
        }
        if ($this->request->designer_id) {
            $designerId = $this->request->designer_id;
            $productAttribute->where(function($q) use($designerId){
                $q->where('designer_id', $this->request->designer_id)
                    ->orWhereNull('designer_id');
            });
        }
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $productAttribute->whereIn('id',$filter_ids);
        }

        $productAttribute = $productAttribute->get();

        $recordArray = array();
        $i = 0;
        foreach ($productAttribute as $key => $value) {
            $recordArray[] = array(
                'col1'=>$value->name,
                'col2'=>$value->type,
                'col3'=>'',
                'col4'=>''
            );
            $options = ProductAttributeVariable::where('product_attribute_id',$value->id);
            if ($this->request->filter_child_ids) {
               $filter_child_ids = explode(',',$this->request->filter_child_ids);
               $options->whereIn('id',$filter_child_ids);
            }
            $options = $options->get();
            $total_count = $options->count();
            $recordArray[$i++]['col4'] = $total_count;
            
            foreach ($options as $option) {
                $recordArray[] = array(
                    'col1'=>'-',
                    'col2'=>$option->option_name,
                    'col3'=>$option->option_value,
                    'col4'=>''
                );
                $i++;
            }
        }

        return $recordArray;
    }

    public function map($recordArray): array
    {

        return [
            $recordArray['col1'],
            $recordArray['col2'],
            $recordArray['col3'],
            $recordArray['col4'],
        ];
    }

    public function headings(): array
    {
        $columns = array('Name', 'Type/Variable', 'Variable Value', 'Total Variable');

        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}