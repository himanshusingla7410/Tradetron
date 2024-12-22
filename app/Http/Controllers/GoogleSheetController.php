<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GoogleSheetController extends Controller
{
    public function fetchGoogleSheetData()
    {
        $userEmail = Auth::user()->email; 
        $url = 'https://script.google.com/macros/s/AKfycbxH6kjjdcImagL2Tc_QGFv5OqeXkCzmvVvrIHfzQ1QG8G4zAO1LeEiN7qO0OPincmuQ_Q/exec?email=' . urlencode($userEmail);

        $response = Http::get($url);
        $data = $response->json();

        //dd($data);

        return view('chatrecord', ['data' => $data]);
    }

    public function fetchAllData(){

        $users= DB::table('users')->pluck('email');

        //dd($users);
        foreach($users as $user){
            echo $user;
        }
        

    }
}
