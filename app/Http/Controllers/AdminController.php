<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller    
{
    public function show(Request $request)
    {      
        $agents = DB::table('users')->get();
        
        $agentId=AgentValidatorController::isValid($request);

        if($agentId !== 'all'){
            $data = QueryController::getAll([$agentId]);
        } else {
            $data = QueryController::getAll();
        }
        
        $todayCount = QueryController::getDailyCount($agentId,1)[0]->count;

        $weekCount = QueryController::getWeeklyCount($agentId,1)[0]->count;

        $monthCount = QueryController::getMonthlyCount($agentId,1)[0]->count;

        return view('admin', compact('data','todayCount','weekCount', 'monthCount','agents'));
        
    }

}
