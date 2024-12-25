<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{   
    protected $quotes = []; 

    public function __construct()
    {
        try {
            $response = Http::get('https://zenquotes.io/api/quotes');

            if ($response->successful()) {
                $this->quotes = $response->json()[0];
            }else{
                $this->quotes= ['error' => 'Failed to fetch quotes'];
            }
                
            
        } catch (\Exception $e) {
             $this->quotes = ['error' => $e->getMessage()];
        };
    }
    


    public function getDashboard() 
    {
        return view('dashboard',['quotes'=> $this->quotes]);
        
    }
}