<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use InvalidArgumentException;

use Laravel\Socialite\SocialiteManager;
use Laravel\Socialite\SocialiteServiceProvider;
use App\Sportkurs;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('sum', function ($attribute, $value, $parameters) {
            $sum = 0;
            foreach($value as $id)
            {
                $sum += Sportkurs::find($id)->bewegungsfeld;
            }

            return $sum == 2;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }
}
