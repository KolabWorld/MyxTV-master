<?php 

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\EquipmentDetail;

class EquipmentExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request;
        $this->serial = 1;
    }

    public function collection()
    {
        $auth = \Auth::user(); 
        $records = EquipmentDetail::where('status','!=','draft')->latest();
        if ($this->request->search) {
            $records->where(function($query){
                $query->where('application_number', 'like', '%' . $this->request->search . '%')
                ->orWhere('equipment_number', 'like', '%' . $this->request->search . '%');
            });
        }
        if($auth->hasRoles(['contractor'])){
            $records->where('company_name', 'like', '%' . $auth->company_name . '%');
        }else{
            if ($this->request->company_name) {
                $records->where('company_name', 'like', '%' . $this->request->company_name . '%');
            }
        } 
        if ($this->request->equipment_type) {
            $records->where('equipment_type_master_id',$this->request->equipment_type);
        }
        
        if ($this->request->due_date) {
            if($this->request->due_date == 'Today'){
                $records->whereDate('inspection_due_date',"=",date('Y-m-d'));
            }
            elseif($this->request->due_date == 'Next 1 Week'){
                $records->whereDate('inspection_due_date',">=",date('Y-m-d'))
                ->whereDate('inspection_due_date',"<=",date('Y-m-d',strtotime("1 week")));
            }
            else{
                $records->whereDate('inspection_due_date',">=",date('Y-m-d'))
                ->whereDate('inspection_due_date',"<=",date('Y-m-d',strtotime("1 month")));
            }
        }
        if($this->request->from_date){
            $records->whereDate('inspection_due_date',">=",date('Y-m-d',strtotime($this->request->from_date)));
        }
        
        if($this->request->to_date){
            $records->whereDate('inspection_due_date',"<=",date('Y-m-d',strtotime($this->request->to_date)));
        }
        
        if ($this->request->created_at) {
            if($this->created_at == 'Today'){
                $records->whereDate('created_at',"=",date('Y-m-d'));
            }
            elseif($this->request->created_at == 'Last 1 Week'){
                $records->whereDate('created_at',"<=",date('Y-m-d'))
                ->whereDate('created_at',">=",date('Y-m-d',strtotime("-1 week")));
            }
            elseif($this->request->created_at == 'Last 15 Days'){
                $records->whereDate('created_at',"<=",date('Y-m-d'))
                ->whereDate('created_at',">=",date('Y-m-d',strtotime("-15 days")));
            }
            elseif($this->request->created_at == 'Last 1 Month'){
                $records->whereDate('created_at',"<=",date('Y-m-d'))
                ->whereDate('created_at',">=",date('Y-m-d',strtotime("-1 month")));
            }
            else{
                
            }
        }else{
            if($this->request->from_date){
                $records->whereDate('created_at',">=",date('Y-m-d',strtotime($this->request->from_date)));
            }
            if($this->request->to_date){
                $records->whereDate('created_at',"<=",date('Y-m-d',strtotime($this->request->to_date)));
            }
        }

        if ($this->request->status=='total_inspection') {
            $records->where(function($query){
                $query->where('status','=','approved')
                ->orWhere('status','=','rejected')
                ->orWhere('status','=','cond-approved');
            });
        }
        else{
            if ($this->request->status) {
                $records->where('status',$this->request->status);
            }
        }

        if ($this->request->obs_status) {
            $records->whereHas('obsLog', function($q){
                $q->whereNotNull($this->request->obs_status);
            });
        }
        
        if ($this->request->expiry_docs) {
            if($this->request->expiry_docs == 'Today'){
                $records->where(function($q){
                    $q->whereDate('istimara_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('third_party_certificate_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('certificate_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('inspection_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('vehicle_registration_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('aramco_certificate_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('dl_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('iquama_expiry_date',"=",date('Y-m-d'))
                    ->orWhereDate('sag_license_validity',"=",date('Y-m-d'))
                    ->orWhereDate('operator_fitness_validity',"=",date('Y-m-d'));
                });
            }
            elseif($this->request->expiry_docs == 'Next 1 Week'){
                $records->where(function($q){
                    $q->where(function($q1){
                        $q1->whereDate('istimara_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('istimara_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('third_party_certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('third_party_certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('inspection_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('inspection_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('vehicle_registration_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('vehicle_registration_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('aramco_certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('aramco_certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('dl_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('dl_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('sag_license_validity',">=",date('Y-m-d'))
                        ->whereDate('sag_license_validity',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('operator_fitness_validity',">=",date('Y-m-d'))
                        ->whereDate('operator_fitness_validity',"<=",date('Y-m-d',strtotime("1 week")));
                    })->orWhere(function( $q1){
                        $q1->whereDate('iquama_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('iquama_expiry_date',"<=",date('Y-m-d',strtotime("1 week")));
                    });
                });
            }
            elseif($this->request->expiry_docs == 'Next 1 Month'){
                $records->where(function($q){
                    $q->where(function($q1){
                        $q1->whereDate('istimara_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('istimara_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('third_party_certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('third_party_certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('inspection_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('inspection_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('vehicle_registration_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('vehicle_registration_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('aramco_certificate_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('aramco_certificate_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('dl_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('dl_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('sag_license_validity',">=",date('Y-m-d'))
                        ->whereDate('sag_license_validity',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('operator_fitness_validity',">=",date('Y-m-d'))
                        ->whereDate('operator_fitness_validity',"<=",date('Y-m-d',strtotime("1 month")));
                    })->orWhere(function($q1){
                        $q1->whereDate('iquama_expiry_date',">=",date('Y-m-d'))
                        ->whereDate('iquama_expiry_date',"<=",date('Y-m-d',strtotime("1 month")));
                    });
                });
            }
        }
        
        $records = $records->get();
        
        return $records;
    }
    
    public function map($records): array
    {
        
        return [
            //$records->application_number,
            //date("Y-m-d",strtotime($records->created_at)),
            $this->serial++,
            $records->company_name,
            //$records->equipment_number,
            @$records->equipmentTypeMaster->name,
            $records->manufacturer_name,
            $records->manufacture_year,
            $records->equipment_number,
            //$records->equipment_model_number,
            //$records->equipment_serial_number,
            $records->capacity,
            $records->insurance_number ? 'YES' : 'NO',
            $records->mobilization_date,
            $records->IntialInspection ? date("Y-m-d",strtotime(@$records->IntialInspection->created_at)) : '' ,
            $records->LastInspection ? @$records->LastInspection->adminType->name : '' ,
            $records->LastInspection ? date("Y-m-d",strtotime(@$records->LastInspection->created_at)) : '' ,
            $records->LastInspection ? (@$records->LastInspection->equipment_detail_status) : '' ,
            'OBSERVATION',
            // $records->status,
            // $this->checkYes($records->is_pwas_status),
            // $records->qr_code_number,
            // $records->operator_email,
            // $records->istimara_number,
            // $records->istimara_expiry_date,
            $records->third_party_company_name,
            $records->third_party_certificate_expiry_date,
            // $records->third_party_certificate_number,
            // $records->third_party_certificate_inspection_date,
            // $this->checkYes($records->is_third_party_certificate_status),
            // $records->third_party_inspector_name,
            // $records->third_party_inspector_aramco_number,
            // $this->checkYes($records->is_motor_vehicle_details),
            // $records->vehicle_plate_number,
            // $records->vehicle_registration_expiry_date,
            // $records->insurance_number,
            $records->insurance_expiry_date,
            $this->checkYes($records->is_pwas_status),
            'MAINTENANCE HISTORY',
            ' ',
            //operator field
            $records->operator_name,
            $records->orientation_date,
            // $records->orientation_date,
            // $records->operator_nationality,
            // $records->sag_license_validity,
            // $records->operator_certificate_model_number,
            // $records->operator_fitness_validity,
            $records->aramco_certificate_number,
            $this->checkYes($records->is_aramco_certificate_status),
            $records->third_party_certificate_number,
            $this->checkYes($records->is_third_party_certificate_status),
            $records->certificate_expiry_date,
            // $records->aramco_certificate_expiry_date,
             $records->dl_number,
             $records->dl_expiry_date,
             $records->iquama_number,
             $records->iquama_expiry_date,
             'VIOLATION HISTORY',
             // $records->equipment_front_photo,
             // $records->equipment_back_photo ,
             // $records->certificate_expiry_date             
            ];
        }
        
        public function headings(): array
        {
            $columns = array(
                'NO',
                //'Application Date',
                'COMPANY',
                
                'EQUIPMENT TYPE',
                'MANUFACTURE COMPANY',
                'MANUFACTURE YEAR',
                'EQUIPMENT NUMBER',
                'CAPACITY',
                'ISTIMARA',
                'MOBILIZATION DATE',
                //'Equipment Model No.',
                'INITIAL INSPETION DATE',
                
                'INSPECTOR NAME',
                'INSPECTION DATE',
                'INSPECTION STATUS',
                'OBSERVATION',
                //'INSPECTOR NAME',
                //'ISTIMARA No.',
                //'ISTIMARA expiry date',
                '3RD PARTY COMPANY NAME',
                '3RD PARTY CERTIFICATE EXPIRED DATE',
                // '3rd Party Certificate No.',
                // '3rd Party Certificate Inspection Date',
                // '3rd Party Certificate Verify Status',
                // '3rd Party Inspector Name',
                // '3rd Party Inspector ARAMCO ID',
                // 'Motor Vehicle Details',
                // 'Vehicle Registration',
                // 'Vehicle Registration Expiry Date',
                // 'Insurance No.',
                'INSURANCE EXPIRED DATE',
                'PWAS STATUS',
                'MAINTENANCE HISTORY',
                ' ',
                'OPERATOR NAME',
                'ORIENTATION DATE',
                
                // 'Operator/Driver Mobile No.',
                // 'Orientation Date',
                // 'Operator Nationality',
                // 'SAG License Validity',
                // 'Operator Certificate Model Number',
                // 'Operator Fitness Validity',
                'ARAMCO CERTIFICATE NUMBER',
                'ARAMCO CERTIFICATE VERIFY STATUS',
                '3RD PARTY CERTIFICATE NUMBER',
                '3RD PARTY CERTIFICATE VERIFY STATUS',
                'CERTIFICATE EXPIRED DATE',
                // 'ARAMCO Certificate Expiry Date',
         'DRIVING LICENSE NUMBER',
         'DRIVER LICENSE EXPIRED DATE',
         'IQAMA NUMBER',
         'IQAMA EXPIRED DATE',
         'VIOLATION HISTORY',
         // 'Equipment Front Photo',
         // 'Equipment Back Photo',
        // 'Certificate Expiry Date'
    );

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

    public function checkYes($num){
       
        switch ($num) {
            case '1':
                $res = 'Yes';
                break;
            case '0':
                $res = 'No';
                break;
            case '2':
                $res = 'N/A';
                break;
            default:
                $res = '-';
                break;
        }
        return $res;
    }
    
}