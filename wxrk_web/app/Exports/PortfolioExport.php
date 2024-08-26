<?php

namespace App\Exports;

use App\Models\Portfolio;
use App\Models\Payout;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PortfolioExport implements FromCollection, WithMapping, WithHeadings
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
        $portfolios = new Portfolio();

        if ($this->request->search) {
            $portfolios->where('title', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->status) {
            $portfolios->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $portfolios->where('designer_id', $this->request->designer_id);
        }

        if ($this->request->designer_id) {
            $portfolios->where('designer_id', $this->request->designer_id);
        }
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $portfolios->whereIn('id',$filter_ids);
        }
        

        $portfolios = $portfolios->get();

        return $portfolios;
    }

    public function map($portfolios): array
    {

        return [
            ucfirst($portfolios->status),
            $portfolios->title,
            dateFormat($portfolios->created_at),
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