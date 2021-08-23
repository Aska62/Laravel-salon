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
    public function __construct(Owner $owner, User $user)
    {
        $this->owner = $owner;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // what we need: owner email, owner name, salon name, user name, user email
        Mail::send('emails.noticeToOwner', ['owner' => $this->owner, 'user' => $this->user], function($message){
            $message->to($this->owner->email)
                ->subject($this->user->salon->name."に新しい会員が参加しました")
                ->from(config('mail.from.address'));
        });
    }
}
