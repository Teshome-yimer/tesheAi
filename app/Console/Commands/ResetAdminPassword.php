<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password
                            {password : New password for the current admin account}
                            {--email= : Reset a specific admin by email if needed}';

    protected $description = 'Reset the password for the current admin account';

    public function handle(): int
    {
        $password = (string) $this->argument('password');
        $email = $this->option('email');

        if (strlen($password) < 6) {
            $this->error('Password must be at least 6 characters.');
            return self::FAILURE;
        }

        $query = User::query()->where('role', 'admin');

        if ($email) {
            $query->whereRaw('LOWER(email) = ?', [strtolower(trim((string) $email))]);
        }

        $user = $query->first();

        if (!$user) {
            $this->error($email
                ? 'No admin account found for that email.'
                : 'No admin account found. Use admin:create to create one.');
            return self::FAILURE;
        }

        $user->update(['password' => $password]);

        $this->info('Admin password reset successfully.');
        $this->line('Email: ' . $user->email);

        return self::SUCCESS;
    }
}
