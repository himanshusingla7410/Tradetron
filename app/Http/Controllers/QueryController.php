<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryController extends Controller 
{
    public static function getColumnData($agentId, string $columnName  ) : array {

        $query = "Select $columnName as data, COUNT(*) as count
                    From chatdetails
        ";

        if($agentId !== 'all'){
            $query .= "Where user_id = ?";
        }
        $query .= "Group by $columnName ";

        return DB::select($query, $agentId !== 'all' ? [$agentId] : []);
    }


    public static function getDailyCount($agentId , int $days=5)  {

        $query= "SELECT DATE(created_at) as data, 
                COUNT(*) as count
                FROM chatdetails
                WHERE 1=1
        ";

        if ($agentId !== 'all'){
            $query .= "AND user_id = ?"
        ;}
        
        if ($days == 1){
            $query .=  "AND DATE(created_at) = date('now')";
        }else {
            $query .= "Group by DATE(created_at)
                    Order by DATE(created_at) DESC
                    LIMIT ?";
        }

        $bindings = [];
        if ($agentId !== 'all') {
            $bindings[] = $agentId;
        }
        if ($days > 1) {
            $bindings[] = $days;
        }
                
        $result = collect(DB::select($query, $bindings))->sortBy('data');

        return $result;        
    }

    
    public static function getWeeklyCount($agentId, int $currentWeek = 5): array{

        $weeksAgo = -7 * ($currentWeek);

        $query = "SELECT strftime('%Y-%W', created_at) as data, 
                COUNT(*) as count
                FROM chatdetails
                WHERE DATE(created_at) >= DATE('now', 'weekday 0', ?)
                AND DATE(created_at) <= DATE('now', 'weekday 0')";
                
        if ($agentId !== 'all'){
            $query .= " AND user_id = ?";
        }
        
        $query .= " GROUP BY strftime('%Y-%W', created_at)
                    ORDER BY strftime('%Y-%W', created_at) ASC";
        
        $bindings=[];
        $bindings[]= "$weeksAgo days";
        
        if( $agentId !== 'all'){
            $bindings[]= $agentId;
        }
        $result = DB::select($query, $bindings);

        if (empty($result)){
            return[
                (object) ['data'=> null, 'count'=> 0]
            ];        }

        return $result;
    }


    public static function getMonthlyCount($agentId, int $days=5) : array{

        $query= "SELECT strftime('%Y-%m', created_at) as data,
                COUNT(*) as count
                FROM chatdetails 
                WHERE 1=1                  
        ";

        if ($agentId !== 'all'){
            $query .= "AND user_id = ?"
        ;}
        
        if ($days == 1 ){
            $query .= "AND strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now')";
        } else {
            $query .= "And created_at > DATE('now', '-12 months')
                    And created_at < DATE('now')
                    Group by strftime('%Y-%m', created_at)
                    Order by strftime('%Y-%m', created_at) ASC";
        }

        return DB::select($query, $agentId !== 'all' ? [$agentId] : []);
    }



    public static function getAll( array $id= []){

        $query = "Select * from chatdetails Order by created_at DESC";

        if (is_array($id) && !empty($id)){
            $result = DB::select("Select * from chatdetails Where user_id = ? Order by created_at DESC",$id); 
        } else {
            $result = DB::select($query);
        }  

        $paginate = PaginationController::paginate($result, 7);

        return $paginate;
    }


}











