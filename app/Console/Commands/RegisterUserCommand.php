<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Factory;
use App\Actions\Auth\RegisterUserAction;
use Illuminate\Validation\Rules\Password;
use Propaganistas\LaravelPhone\Exceptions\CountryCodeException;

class RegisterUserCommand extends Command
{
    protected $signature = 'register
                            {first_name? : User first name.}
                            {last_name? : User last name.}
                            {email? : User email.}
                            {phone? : User phone.}
                            {password? : User password.}
                            {role? : User role to be assign to.}';

    protected $description = 'Register a new user.';

    /** @throws CountryCodeException */
    public function handle(Factory $validator): int
    {
        $validatedData = $this->validateData($validator);

        $user = RegisterUserAction::execute($validatedData);

        if ($user->exists) {

            $user->assignRole($validatedData['role']);

            $this->info("User [{$user->getAttribute('email')}] has been registered.");
        }

        return Command::SUCCESS;
    }

    protected function data(): array
    {
        return [
            'first_name' => $this->argument('first_name')
                ?? $this->ask('what is the user\'s first name?'),
            'last_name' => $this->argument('last_name')
                ?? $this->ask('what is the user\'s last name?'),
            'email' => $this->argument('email')
                ?? $this->ask('what is the user\'s email?'),
            'phone' => $this->argument('phone')
                ?? $this->ask('what is the user\'s phone number?'),
            'password' => $this->secret('password')
                ?? $this->ask('what is the user\'s password?'),
            'role' => $this->choice(
                'what role should be assign to this user?',
                $this->getRoles(),
                0
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [Password::required()],
            'role' => ['required', 'exists:roles,name'],
        ])->validate();
    }
}
