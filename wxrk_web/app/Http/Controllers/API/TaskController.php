<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Auth;
use Uuid;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use App\Services\LoggerFactory;

use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use App\Exceptions\ApiGenericException;

use App\Models\Task;
use App\Models\TaskFile;

/**
 * Handling all requests related to GTM tracking
 */
class TaskController extends Controller
{
    
    protected $log;

    public function __construct(LoggerFactory $logFactory)
    {
        $this->log = $logFactory->setPath('logs/api')->createLogger('task');
    }

    /**
     * store data in db for gtm tracking details
     * 
     * @param $request Request
     */
    public function index()
    {
        $user = Auth::guard('api')->user();
        $tasks = Task::where('assigned_to', $user->id)
                        ->orderBy('created_at', 'DESC')
                        ->where('status', '=', 'new')
                        ->limit(10)
                        ->get();

        $otherTask = Task::where('created_by', $user->id)
                        ->where('assigned_to','!=', $user->id)
                        ->orderBy('created_at', 'DESC')
                        ->where('status', '=', 'new')
                        ->limit(10)
                        ->get();

        return array(
            'tasks' => $tasks,
            'other' => $otherTask
        );
    }  

    public function getTasks($type = 'self',$month='') {

        $user = Auth::guard('api')->user();
        $month = $month ?: Carbon::today()->format('Y-m');
        $tasks = Task::whereRaw("created_at LIKE '$month%'");

        if($type == 'other') {
            $tasks = $tasks->where('created_by', $user->id)
                            ->where('assigned_to', $user->id);
        }
        else {
            $tasks = $tasks->where('assigned_to', $user->id);
        }

        return $tasks->get();
    }

    public function updateStatus($id, $status) {

        $task = Task::find($id);
        $task->status = $status;

        $task->save();

        return $task;
    }

    public function reAssign(Request $request,$id) {

        $auth = Auth::guard('api')->user();
        $task = Task::find($id);
        $task->assigned_to = $request->assigned_to;

        $task->save();

        return $task;
    }

    public function store(Request $request) {
        $this->log->info("AddTask AllData: ". json_encode($request->all()));

        $auth = Auth::guard('api')->user();
        $transactionNo = Uuid::generate(4);
        $task = new Task;
        $task->fill($request->all());
        $task->status = "new";
        $task->created_by = $auth->id;
        $task->save();
        if ($request->file) {
            $taskFile = new TaskFile;
            //get the base-64 from data
            $base64_str = substr($request->file, strpos($request->file, ",")+1);
            //decode base64 string
            $image = base64_decode($base64_str);
            $safeName = $transactionNo.'.'.'png';
            // Storage::disk('public')->put('eejaz/'.$safeName, $image);
            $path = Storage::disk('public')->put('uploads/task-files/'.$safeName, $image);
            $taskFile->task_id = $task->id;      
            $taskFile->file = $safeName;
            $this->log->info("AddTask file: ". $safeName ." ,Path: ".$taskFile->file);
            $taskFile->save();
        }

        return $task;
    }

    public function update(Request $request, $id) {

        $task = Task::find($id);
        $task->fill($request->all());
        $task->save();

        return $task;
    }

     public function view($id) {

        $task = Task::with('files')
                ->find($id);
        return $task;
    }
}
