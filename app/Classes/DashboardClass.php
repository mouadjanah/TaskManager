<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class DashboardClass
{
    private $task;
    public function __construct(Task $task)
    {
        $this->task = $task;    }
    public function getCount(){
        try {
            $email_id = Common::AuthID();
            $data = [];


            $getTotalTask = $this->task->getTotalTask($email_id);
            $getCompleteTask = $this->task->getCompleteTask($email_id);

            $data["totalTask"] = $getTotalTask;
            $data["completeTask"] = $getCompleteTask;

            if (isset($data) && !empty($data)){
                return response()->json(["status"=>true,"message"=>"dashboard count get success","data"=>$data])->setStatusCode(200);
            }
            return response()->json(["status"=>false,"message"=>"error while get dashboard data"])->setStatusCode(400);
        }catch (\Exception $ex){
            Log::info("DashboardClass Error",["getCount"=>$ex->getMessage(),"line"=>$ex->getLine()]);
            return response()->json(["status"=>false,"message"=>"internal server Error"])->setStatusCode(500);
        }
    }
}
