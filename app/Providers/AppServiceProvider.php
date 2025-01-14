<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Validator::extend('pdf', function ($attribute, $value, $parameters, $validator) {
            // Check if the uploaded file's extension is 'pdf'
            $extension = $value->getClientOriginalExtension();
            return in_array($extension, ['pdf', 'PDF']);
        });
    }
}
