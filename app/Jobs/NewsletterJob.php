<?php

namespace App\Jobs;

use App\Mail\Newsletter;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterJob implements ShouldQueue
{
    use Batchable, Queueable;

    public $timeout = 600; // max time a job can run for 10 mins
    public $failOnTimeout = true;

    public $tries = 3; // how many times job should be attempted if encountered error
    /**
     * Create a new job instance.
     */
    public function __construct(protected $subscriber)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            Log::info('Job initiated for: ' . $this->subscriber->email);

            $this->subscriber->update([
                'mail_sent_status' => 'sending'
            ]);

            Mail::to($this->subscriber->email)->queue((new Newsletter($this->subscriber))->onQueue('newsletter'));

            $this->subscriber->update([
                'last_mail_sent' => now(),
                'mail_sent_status' => 'Sent',
            ]);

            Log::info('Mail status updated from sending to sent for: ' . $this->subscriber->email);
        } catch (\Exception $e) {

            $this->subscriber->update([
                'mail_sent_status' => 'Failed'
            ]);

            Log::error("Failed sending mail to {$this->subscriber->email}: " . $e->getMessage());

            throw $e;
        }
    }

    public function retryUntil(){

        return now()->addMinutes(35);
    }

    public function middleware(){

        return [new RateLimited('jobs')];

    }
}
