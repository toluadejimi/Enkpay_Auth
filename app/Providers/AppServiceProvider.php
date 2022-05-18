<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void
    {
        //
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerTheme(mix('css/app.css'));

            Filament::registerUserMenuItems([
                /*'account' => UserMenuItem::make()
                    ->label(__('Your Profile'))
                    ->url($url),
                UserMenuItem::make()
                    ->label(__('Manage Users'))
                    ->url($label)
                    ->icon($label),*/
            ]);
        });

        Model::unguard();
    }
}
