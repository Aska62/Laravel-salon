<?php

namespace App\Jobs;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToOwner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $owner;
    private $user;

    /**
     * Create a new job instance.
     *
     * @param App\Models\Owner
     * @param App\Models\User
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.noticeToOwner', ['user' => $this->user], function($message) {
            $message->to($this->user->salon->owner->email)
                ->subject($this->user->salon->name."に新しい会員が参加しました")
                ->from(config('mail.from.address'));
        });
    }
}
