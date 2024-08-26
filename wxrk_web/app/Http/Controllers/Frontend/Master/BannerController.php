<?php

namespace App\Http\Controllers\Frontend\Master;

use App\Models\EquipmentTypeMaster;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AdminController;

use Illuminate\Validation\ValidationException;
use App\Lib\Validation\Master as Validator;
use App\Models\ChecklistGroup;
use App\Models\ChecklistMaster;
use App\Models\EquipmentChecklistMapping;

class BannerController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = \Auth::user();

        // $equipments = EquipmentTypeMaster::latest();

        // if ($request->search) {
        //     $equipments->where('name', 'like', '%' . $request->search . '%');
        // }

        // $equipments = $equipments->paginate(10);

        return view('frontend.master.banner.index', [
            'tab' => 'banners',
            'user' => $user,
            // 'records' => $equipments,
        ]);
    }

    public function create()
    {
        $user = \Auth::user();

        return view('frontend.master.banner.create_edit',
            array(
                'tab' => 'banners',
                'user' => $user,
            )
        );
    }

    public function store(Request $request)
    {
        $auth = \Auth::guard('admin')->user();
        $validator = (new Validator($request))->storeEquipmentTypeMaster();
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $equipment = new EquipmentTypeMaster();
        $equipment->fill($request->all());
        $equipment->save();

        foreach ($request->checklist as $checklist) {
            $mapping = new EquipmentChecklistMapping();
            $mapping->equipment_type_id = $equipment->id;
            $mapping->checklist_master_id = $checklist;
            $mapping->save();
        }

        if ($equipment && $equipment->id) {
            return redirect('/equipment-types')->with(['success' => "Equipment Type added successfully!!!"]);
        } else {
            return redirect('/equipment-types')->with(['error' => "Something went wrong. Please try again"]);
        }
    }

    public function show()
    {
        return view('admin.master.blog-category.view');
    }

    public function edit($id)
    {
        $equipment = EquipmentTypeMaster::find($id);
        $checklists = ChecklistGroup::with(['checklists'])->select('id', 'name')->get();

        return view(
            'frontend.master.equipment-type.create_edit',
            array(
                'equipment' => $equipment,
                'checklists' => $checklists,
                'tab' => 'equipment',
            )
        );
    }

    public function update(Request $request, $id)
    {
        $auth = \Auth::guard('admin')->user();

        $request->request->add(['id' => $id]);
        $validator = (new Validator($request))->updateEquipmentTypeMaster();
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $equipment = EquipmentTypeMaster::find($id);
        $equipment->fill($request->all());
        $equipment->update();

        EquipmentChecklistMapping::where('equipment_type_id', $equipment->id)->whereNotIn('checklist_master_id', $request->post('checklist'))->delete();
        foreach ($request->post('checklist') as $checklistId) {
            EquipmentChecklistMapping::updateOrCreate([
                'equipment_type_id' => $equipment->id,
                'checklist_master_id' => $checklistId,
            ], []);
        }

        if ($equipment && $equipment->id) {
            return redirect('/equipment-types')->with(['success' => "Equipment Type updated successfully!!!"]);
        } else {
            return redirect('/equipment-types')->with(['error' => "Something went wrong. Please try again"]);
        }
    }

    public function destroy($id)
    {
        $equipment = EquipmentTypeMaster::find($id);
        if ($equipment) {
            if ($equipment->applications && (count($equipment->applications) > 0)) {
                return [
                    'message' => "Please delete all the mappings for this record, after that you can delete this record!",
                ];
            } else {
                $equipment->delete();
                return [
                    'message' => "Record deleted successfully!"
                ];
            }
        } else {
            return [
                'message' => "Record does not exist!"
            ];
        }
    }
}
