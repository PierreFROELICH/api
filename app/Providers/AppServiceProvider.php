<?php

namespace App\Providers;

use App\Helpers\ImageHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('image_base64', function ($attribute, $value, $parameters, $validator) {
            if(empty($value)){
                return true;
            }
            return ImageHelper::checkFormatBase64($value, $parameters);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
