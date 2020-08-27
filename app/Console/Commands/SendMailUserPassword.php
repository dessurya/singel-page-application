<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Model\User;
use App\Mail\LoginLinkMail;
use Illuminate\Support\Facades\Mail;

class SendMailUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendMail:UserPassword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail Users Password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('send','Y')->whereNull('password')->whereNotNull('remember_token')->orderBy('updated_at', 'asc')->limit(5)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new LoginLinkMail($user));
            $store = User::find($user->id);
            $store->send = 'N';
            $store->save();
        }
        if (count($users) > 0) {
            Log::notice('Send Mail Users Password for '.json_encode($users));
        }
    }
}
