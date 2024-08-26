<?php

namespace App\Exports;

use App\Models\Offer;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfferExport implements FromCollection, WithMapping, WithHeadings
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
        $offers = Offer::with('offerCategories')->orderBy('id', 'DESC');

        if ($this->request->search) {
            $offers->where('title', 'like', '%' . $this->request->search . '%');
        }
        if ($this->request->status) {
            $offers->where('status', $this->request->status);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $offers->whereIn('id',$filter_ids);
        }

        $offers = $offers->get();

        return $offers;
    }

    public function map($offers): array
    {

        return [
            $offers->status,
            $offers->title,
            count($offers->offerCategories),
            '#NA',
            $offers->from_date,
            $offers->end_date,
            $offers->descriptions,
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'Offer', 'Categories', 'Designers', 'From Date', 'End Date', 'Description');

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