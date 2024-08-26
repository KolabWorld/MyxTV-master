<?php

namespace App\Imports;

use App\Models\EquipmentTypeMaster;
use App\Models\ChecklistMaster;
use App\Models\EquipmentChecklistMapping;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EquipmentImport implements ToArray
{
    /**
    * @param Collection $collection
    */

    public  $errors = array();

    public function array(array $rows)
    {
        foreach($rows as $key=>$row){
            if(!isset($row[0])) continue;
        
            $equipment = $this->getEquipmentId($row[1]);
            $checklist = $this->getChecklistId($row[2]);
            
            if($checklist && $equipment){
                $map = new EquipmentChecklistMapping();
                $map->equipment_type_id = $equipment;
                $map->checklist_master_id = $checklist;
                $map->save();
            }else{
                array_push($this->errors,($key+1).' / '.$row[1].' / '.$row[2]);
            }
        }
    }

    public function getEquipmentId($name){
        $eq = EquipmentTypeMaster::where("name",'=',$name)->first();

        if($eq){
            return $eq->id;
        }

        return 0;
    }

    public function getChecklistId($name){
        $ck = ChecklistMaster::where("name",'=',$name)->first();

        if($ck){
            return $ck->id;
        }

        return 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
