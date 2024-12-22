<?php

namespace App\Http\Controllers;

use App\Mail\ChatEscalated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function store(){
      
        // Validating inputs
        request()->validate([
            'status.*'=>['required'],
            'issueType.*'=>['required'],
            'calledClient.*'=>['required'],
            'chatLink.*'=> ['required','url'],
        ]);

        $data = request()->all(); // Storing all submitted data in variable
        $count = count($data['status']); // Counting number of forms submitted
        
        // Executing insert sql query
        for ($i=0; $i < $count; $i++){ 

            if ($data['status'][$i] == 'Escalated') {
                Mail::to(Auth::user())->send(
                    new ChatEscalated($data['chatLink'][$i])
                );
            }

            DB::insert('insert into chatdetails(user_id,status_of_chat,issue_type,called_cilent,comments,chat_link,created_at,updated_at) values(?,?,?,?,?,?,?,?)',[

                Auth::user()->id,
                $data['status'][$i],
                $data['issueType'][$i],
                $data['calledClient'][$i],
                $data['comment'][$i],
                $data['chatLink'][$i], 
                now(),
                now()
            ]);
        }
        
        return redirect('/dashboard');
    }


    public function show(){

        $data = QueryController::getAll([Auth::id()]);

        $todayCount = QueryController::getDailyCount(Auth::id(),1)[0]->count;
        
        $weekCount = QueryController::getWeeklyCount(Auth::id(),1)[0]->count;

        $monthCount = QueryController::getMonthlyCount(Auth::id(),1)[0]->count;               
                        
        return view('chatrecord', compact('data','todayCount','weekCount','monthCount'));
    }


}
