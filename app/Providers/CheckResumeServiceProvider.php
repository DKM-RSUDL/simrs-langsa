<?php

namespace App\Providers;

use App\Services\CheckResumeService;
use Illuminate\Support\ServiceProvider;

class CheckResumeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CheckResumeService::class, function ($app) {
            return new CheckResumeService();
        });
    }

    public function boot()
    {
        //
    }
}