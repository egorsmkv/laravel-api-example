<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Data\Models\User;

class CreateUser extends Command
{
    protected $signature = 'app:create-user {email}';
    protected $description = 'Creates a user';

    public function handle(): void
    {
        $email = $this->argument('email');
        /** @var Builder|User $user */
        $user = User::query()->where(['email' => $email]);
        if ($user->exists()) {
            $this->error('User exists.');
            return;
        }

        $password = Str::random();

        /** @var User $newUser */
        $newUser = User::query()->create([
            'name' => 'admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->comment('User created.');
        $this->comment('---');

        $this->comment('E-Mail: ' . $newUser->email);
        $this->comment('Password: ' . $password);
    }
}
