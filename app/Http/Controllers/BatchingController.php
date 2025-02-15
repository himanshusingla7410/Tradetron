<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Support\Facades\Bus;

class BatchingController extends Controller
{
    public static function newsletter( array $data){

        $row=Batch::create([
            'batchID' => "",
            'name'=> 'newsletter',
            'progress' => 0,
            'status' => 'processing'
        ]);

        Bus::batch($data)
            ->name('newsletterBatch')
            ->allowFailures()
            ->onQueue('newsletter')
            ->then( function($batch) use ($row){
                $row->update([
                    'batchID' => $batch->id,
                    'name'=> 'newsletter',
                    'progress' => $batch->progress(),
                    'status'=> 'processed'
                ]);
            })
            ->catch(function($batch) use($row){
                $row->update([
                    'batchID' => $batch->id,
                    'name'=> 'newsletter',
                    'progress' => $batch->progress(),
                    'status'=> 'failed'
                ]);

            })
            ->finally(function($batch) use($row){
                $row->update([
                    'batchID' => $batch->id,
                    'name'=> 'newsletter',
                    'progress' => $batch->progress(),
                    'status'=> 'completed'
                ]);

            })
            ->dispatch();

    }
}
