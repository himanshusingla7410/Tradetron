<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Charts\AnalyticsChart;

class ChartController extends Controller
{
    public function show( Request $request){
        
        $agents = DB::table('users')->get();
        $agentId = AgentValidatorController::isValid($request); // Validating agent ID

        //Fetching data & Displaying chart for Issue Types
        $issueType = QueryController::getColumnData($agentId, 'issue_type');
        $issueTypeChart = $this->createChart($issueType, 'Issue Type', 'pie','Issue Type');

        //Fetching data & Displaying chart for called cilents
        $calledClients = QueryController::getColumnData($agentId,'called_cilent');
        $calledClientsChart = $this->createChart($calledClients, 'Called Clients','pie','Called Clients');

        //Fetching data & Displaying chart for Daily Chat Counts
        $dailyCount= QueryController::getDailyCount($agentId);
        $dailyCountChart = $this->createChart($dailyCount, 'Daily Count', 'bar','Daily Count');

        //Fetching data & Displaying chart for Monthly Chat Counts
        $monthlyCount= QueryController::getMonthlyCount($agentId);
        $monthlyCountChart = $this->createChart($monthlyCount, 'Monthly Count', 'bar','Monthly Count');    

        return view('chart', compact('agents','issueTypeChart','dailyCountChart','monthlyCountChart', 'calledClientsChart'));
    }


    public function createChart($data, string $name = 'Chart', string $chartType = 'bar', string $title='Chart'){
        
        foreach( $data as $item){
            $label[]= $item->data;
            $dataset[]= $item->count;
        }

        $chart = new AnalyticsChart;
        $chart->labels($label);
        $chart->dataset($name,$chartType,$dataset)->backgroundColor( $chartType !== 'bar' ?  ['#FFCA28','#F44336', '#4CAF50'] : '#F44336');
        $chart->title($title, 18,'#3d4642','bold','Helvetica');
        return $chart;
    }

}
