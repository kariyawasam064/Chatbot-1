<?php
use Livewire\Livewire;

public function boot(): void
{
    Carbon::setLocale(config('app.locale'));
    date_default_timezone_set('Asia/Colombo'); // Set timezone globally

    // Force HTTPS in production
    if ($this->app->environment('production')) {
        \URL::forceScheme('https');
    }

    // Fix Livewire Redirect Issues
    if ($this->app->environment('production')) {
        Livewire::setUpdateRoute(function ($handle) {
            return url()->to('/livewire/update', ['handle' => $handle]);
        });
    }
}
