<?php

namespace App\Exports;

use App\Models\Offer;
use App\Models\OrderItem;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection, WithMapping, WithHeadings
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
        $orderItems = OrderItem::with(['order']);

        if ($this->request->status) {
            $orderItems->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $orderItems->where('designer_id', $this->request->designer_id);
        }
        if ($this->request->user_id) {
            $orderItems->join('orders', 'orders.id', '=', 'order_id');
            $orderItems->where('orders.user_id', $this->request->user_id);
        }

        if ($this->request->start_date && $this->request->end_date) {
            $orderItems->whereDate('created_at', '>=', $this->request->start_date)
                ->whereDate('created_at', '<=', $this->request->end_date);
        }

        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $orderItems->whereIn('id',$filter_ids);
        }

        $orderItems = $orderItems->get();


        return $orderItems;
    }

    public function map($orderItems): array
    {
        //dd($orderItems->toArray());
        
        if (isset($orderItems->order->user['billing_address']['country_name']['name'])) {
            $address = $orderItems->order->user['billing_address']['country_name']['name'];
        } else {
            $address = '-';
        }
        
        return [
            $orderItems->status,
            $orderItems->product_attributes['product'] ? $orderItems->product_attributes['product']['code'] : '-',
            $orderItems->order->order_number,
            $orderItems->designer ? $orderItems->designer['name'] : '-',
            $orderItems->order->user_name,
            $address,
            date('jS M Y', strtotime($orderItems->created_at)),
            $orderItems->total_amount
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'SU', 'Order ID', 'Designer', 'Customer', 'Customer Location', 'Order Date', 'Amount');

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