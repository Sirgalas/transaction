<?php

namespace App\Providers;

use App\Entities\Payments\Interfaces\PaymentCodeGeneratorInterface;
use App\Entities\Payments\UniqPaymentCodeGenerator;
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
        $this->app->singleton(PaymentCodeGeneratorInterface::class,UniqPaymentCodeGenerator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
