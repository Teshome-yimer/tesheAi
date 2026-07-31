<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {email : Email address for the admin account}
                            {password : Password for the admin account}
                            {--name=Admin User : Display name}
                            {--phone= : Optional phone number}';

    protected $description = 'Create or promote an admin account for recovery purposes';

    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));
        $password = (string) $this->argument('password');
        $name = trim((string) $this->option('name')) ?: 'Admin User';
        $phone = $this->option('phone');

        if (strlen($password) < 6) {
            $this->error('Password must be at least 6 characters.');
            return self::FAILURE;
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($user) {
            $user->update([
                'name' => $name,
                'phone' => $phone ?: $user->phone,
                'password' => $password,
                'role' => 'admin',
            ]);
            $action = 'updated';
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
                'role' => 'admin',
            ]);
            $action = 'created';
        }

        User::where('id', '!=', $user->id)
            ->where('role', 'admin')
            ->update(['role' => 'student']);

        $this->info("Admin account {$action} successfully.");
        $this->line('Email: ' . $user->email);
        $this->line('Role: ' . $user->role);
        $this->line('All other admins were demoted to student.');

        return self::SUCCESS;
    }
}
