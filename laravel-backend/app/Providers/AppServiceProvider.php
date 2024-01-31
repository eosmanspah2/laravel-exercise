<?php

namespace App\Providers;

use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\ProductTypeServiceInterface;
use App\Services\Contracts\VariantServiceInterface;
use App\Services\ProductService;
use App\Services\ProductTypeService;
use App\Services\VariantService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductTypeServiceInterface::class, ProductTypeService::class);
        $this->app->bind(VariantServiceInterface::class, VariantService::class);
    }

    public function boot(): void
    {
        //
    }
}
