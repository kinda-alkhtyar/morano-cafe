<?php
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
Artisan::command('inspire', fn () => $this->comment('MORANO+'));

Artisan::command('morano:create-admin', function () {
    $name = trim($this->ask('Name'));
    $email = strtolower(trim($this->ask('Email')));
    $password = $this->secret('Password (at least 12 characters)');

    if ($name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password ?? '') < 12) {
        $this->error('A name, valid email, and password of at least 12 characters are required.');
        return 1;
    }
    if (User::where('email', $email)->exists()) {
        $this->error('This email already belongs to an account.');
        return 1;
    }
    if (! $this->confirm("Create a verified admin for {$email}?")) {
        return 1;
    }

    $user = User::create(['name' => $name, 'email' => $email, 'password' => $password]);
    $user->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();
    $this->info('Admin account created.');
    return 0;
})->purpose('Interactively create the first verified MORANO+ administrator');
