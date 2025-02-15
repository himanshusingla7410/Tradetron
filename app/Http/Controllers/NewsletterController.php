<?php

namespace App\Http\Controllers;

use App\Jobs\NewsletterJob;
use App\Models\Subscribers;
use Exception;

class NewsletterController extends Controller
{

    public function send()
    {

        if (! Subscribers::where('status', 'active')->exists()) {
            throw new Exception('No record found for subcribers!');
        }

        $chunkSize = 5;

        Subscribers::where('status', 'active')
            ->chunk($chunkSize, function ($subscribers) {
                $jobs = [];

                foreach ($subscribers as $subscriber) {
                    $jobs[] = new NewsletterJob($subscriber);
                }

                BatchingController::newsletter($jobs);

                return false;
            });



        return view('marketing');
    }
}
