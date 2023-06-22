<?php

namespace App\Console\Commands;

use App\Models\Enums\UserState;
use App\Models\User;
use App\Support\Utils;
use Illuminate\Console\Command;

class AllUsersActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpvms:active_all_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes all users active status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (is_null($user->api_key)) {
                $user->api_key = Utils::generateApiKey();
            }
            $user->save();
        }
        return 0;
    }
}
