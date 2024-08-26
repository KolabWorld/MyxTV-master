<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Models\Payout;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AppointmentExport implements FromCollection, WithMapping, WithHeadings
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
        $appointments = Appointment::with('user');

        if ($this->request->search) {
            $appointments->where('name', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->status) {
            $appointments->where('status', $this->request->status);
        }

        if ($this->request->designer_id) {
            $appointments->where('designer_id', $this->request->designer_id);
        }

        if ($this->request->designer_id) {
            $appointments->where('designer_id', $this->request->designer_id);
        }
        if ($this->request->filter_ids) {
           $filter_ids = explode(',',$this->request->filter_ids);
           $appointments->whereIn('id',$filter_ids);
        }
        

        $appointments = $appointments->get();

        return $appointments;
    }

    public function map($appointments): array
    {

        return [
            ucfirst($appointments->status),
            $appointments->booking_id,
            ucfirst($appointments->user ? $appointments->user->name : '-'),
            ucfirst($appointments->user ? $appointments->user->email : '-'),
            dateFormat($appointments->created_at),
            timeFormat($appointments->created_at)
        ];
    }

    public function headings(): array
    {
        $columns = array('Status', 'Appointment ID', 'Customer', 'Email address', 'Date', 'Time');

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