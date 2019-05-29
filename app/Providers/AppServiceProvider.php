<?php

namespace App\Providers;

use App\Rules\SetRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('set', function ($attribute, $value, $parameters, $validator) {
            $setClass = $parameters[0] ?? null;

            return (new SetRule($setClass))->passes($attribute, $value);
        });
    }
}
