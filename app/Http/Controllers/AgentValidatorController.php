<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AgentValidatorController extends Controller
{
    public static function isValid(Request $request){
        
        $agentID = $request->query('agent','all'); 

        if ($agentID == 'all'){
            return $agentID;
            
        } else {    
            $max_id =DB::select("Select Max(id) as max from users")[0]->max;

            if ($agentID > $max_id){
                abort(404);
            }
        }

        return $agentID;

    }
}
