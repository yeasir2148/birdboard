<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\NewUserRegistrationMail;
use Illuminate\Support\Facades\Mail;

class SendNewUserRegEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    public $tries = 2;
    public $retryAfter = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $email = new NewUserRegistrationMail();
      Mail::to($this->details['email'])->send($email);
      // throw new \Exception("I am throwing exception as a test");
    }
}
