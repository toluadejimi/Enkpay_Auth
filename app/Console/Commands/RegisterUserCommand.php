<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rules\Password;
use App\Actions\Auth\ConsoleUserRegistrationAction;

class RegisterUserCommand extends Command
{
    protected $signature = 'register
                            {email? : User email.}
                            {password? : User password.}
                            {role? : User role to be assign to.}';

    protected $description = 'Register a new user.';

    public function handle(Factory $validator): int
    {
        $validatedData = $this->validateData($validator);

        $user = ConsoleUserRegistrationAction::execute($validatedData);

        if ($user->exists) {

            $user->assignRole($validatedData['role']);

            $this->info("User [{$user->getAttribute('email')}] has been registered.");
        }

        return Command::SUCCESS;
    }

    protected function data(): array
    {
        return [
            'email' => $this->argument('email')
                ?? $this->ask('what is the user\'s email?'),
            'password' => $this->secret('password')
                ?? $this->ask('what is the user\'s password?'),
            'role' => $this->choice(
                'what role should be assign to this user?',
                $this->getRoles(),
                0 // DefaultIn
            ),
        ];
    }

    protected function getRoles(): array
    {
        return (array) Role::query()->pluck('name')->toArray();
    }

    protected function validateData(Factory $validator): array
    {
        return $validator->make($this->data(), [
            'email' => ['required', 'email', 'unique:users'],
            'password' => Password::required(),
            'role' => ['required', 'exists:roles,name'],
        ])->validate();
    }
}
