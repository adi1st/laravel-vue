<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CraeteAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $first_name = $this->ask('First name');
        $last_name  = $this->ask('Last name');
        $email      = $this->ask('Email');
        $password   = $this->secret('Password');

        if (User::where('email', $email)->exists()) {
            $this->error('Email already exists!');
            return;
        }

        $roles = Role::pluck('name')->toArray();
        if (empty($roles)) {
            $this->error('No roles found. Please create some roles first.');
            return;
        }

        $role = $this->choice('Select a role for this user', $roles, 0);

        $user = User::create([
            'name'              => $first_name . ' ' . $last_name,
            'email'             => $email,
            'email_verified_at' => now(),
            'password'          => Hash::make($password),
        ]);

        $user->assignRole($role);

        $this->info("User {$user->email} created and assigned role: {$role}");

    }
}
