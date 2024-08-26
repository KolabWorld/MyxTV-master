<?php

namespace App\Exports;

use App\Models\Payout;
use App\Helpers\ConstantHelper;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayoutExport implements FromCollection, WithMapping, WithHeadings
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
        $payouts = Payout::orderBy('id', 'DESC');

        if ($this->request->search) {
            $payouts->where('transaction_id', $this->request->search);
        }

        if ($this->request->status) {
            $payouts->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $payouts->where('designer_id', $this->request->designer_id);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $payouts->whereIn('id',$filter_ids);
        }

        $payouts = $payouts->get();

        return $payouts;
    }

    public function map($payouts): array
    {

        return [
            ucfirst($payouts->status),
            $payouts->transaction_id,
            ucfirst($payouts->payout_for),
            ucfirst($payouts->designer ? $payouts->designer->name : '-'),
            $payouts->total_deducted_fee,
            $payouts->total_payout,
            dateFormat($payouts->created_at)
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'TXN ID', 'For', 'Name', 'Total Fee Deducted', 'Total Payout', 'Est. Payout Date');

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