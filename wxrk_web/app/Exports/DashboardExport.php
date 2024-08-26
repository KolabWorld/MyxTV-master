<?php

namespace App\Exports;

use App\User;
use App\Models\Address;
use App\Models\Designer;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DashboardExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request;
        $this->index = 1;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;

        if ($this->request->type == 'Designer') {
            $data = Designer::join('order_items', 'order_items.designer_id', '=', 'designers.id')
                ->whereDate('order_items.created_at', '>=', $start_date)
                ->whereDate('order_items.created_at', '<=', $end_date)
                ->selectRaw('designers.*, COALESCE(sum(total_amount),0) total_amount,COALESCE(sum(quantity),0) total_quantity')
                ->groupBy('designers.id')
                ->orderBy('total_amount', 'DESC')
                ->get();
        } else if ($this->request->type == 'Country') {
            $data = Address::join('countries', 'countries.id', '=', 'addresses.country_id')
                ->join('orders', 'addresses.addressable_id', '=', 'orders.billing_address_id')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereDate('order_items.created_at', '>=', $start_date)
                ->whereDate('order_items.created_at', '<=', $end_date)
                ->selectRaw('countries.*, COALESCE(sum(total_amount),0) total_amount,COALESCE(sum(quantity),0) total_quantity')
                ->groupBy('countries.id')
                ->orderBy('total_amount', 'DESC')
                ->get();
        } else {
            $data = User::join('orders', 'orders.user_id', '=', 'users.id')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereDate('order_items.created_at', '>=', $start_date)
                ->whereDate('order_items.created_at', '<=', $end_date)
                ->selectRaw('users.*, COALESCE(sum(total_amount),0) total_amount,COALESCE(sum(quantity),0) total_quantity')
                ->groupBy('users.id')
                ->orderBy('total_amount', 'DESC')
                ->get();
        }

        return $data;
    }

    public function map($data): array
    {
        return [
            $this->index++,
            $data->name,
            $data->total_quantity,
            $data->total_amount
        ];
    }

    public function headings(): array
    {
        $columns = array('#', $this->request->type, 'Quantity', 'Sales');

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