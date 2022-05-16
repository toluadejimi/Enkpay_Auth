<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Livewire\Redirector;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Checkbox;
use App\Providers\RouteServiceProvider;
use Filament\Forms\Components\TextInput;
use App\View\Components\Layouts\AuthLayout;
use Filament\Forms\Concerns\InteractsWithForms;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

/** @property ComponentContainer $form */
class Login extends Component implements HasForms
{
    use WithRateLimiting;
    use InteractsWithForms;

    public ?string $email = '';
    public ?string $password = '';
    public bool $remember = false;

    public function mount(): void
    {
        if (Auth::check()) {
            redirect(RouteServiceProvider::HOME());
        }

        $this->form->fill(['remember' => false]);
    }

    public function authenticate(): RedirectResponse|Redirector|null
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament::login.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return null;
        }

        $data = $this->form->getState();

        if (! Filament::auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'])) {
            $this->addError('email', __('filament::login.messages.failed'));

            return null;
        }

        // Make sure staff do not have access to web platform except
        // through specific permission.
        /*if (Auth::user()->isStaff()) {
            Auth::guard('web')->logout();

            abort(403);
        }*/

        return redirect(RouteServiceProvider::HOME());
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->label(__('Email address'))
                ->placeholder(__('Email address'))
                ->autocomplete()
                ->required(),
            TextInput::make('password')
                ->password()
                ->label(__('Password'))
                ->placeholder(__('Password'))
                ->required(),
            Checkbox::make('remember')
                ->label(__('Remember me'))
                ->default(false),
        ];
    }

    public function render(): View
    {
        return view('livewire.auth.login')
            ->layout(AuthLayout::class);
    }
}
