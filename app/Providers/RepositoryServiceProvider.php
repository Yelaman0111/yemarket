<?php

namespace App\Providers;

use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ProductCompanyRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductCompanyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BrandRepositoryInterface::class, 
            BrandRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class, 
            CategoryRepository::class
        );

        $this->app->bind(
            CompanyRepositoryInterface::class, 
            CompanyRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class, 
            OrderRepository::class
        );

        $this->app->bind(
            ProductCompanyRepositoryInterface::class, 
            ProductCompanyRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class, 
            ProductRepository::class
        );

        $this->app->bind(
            ShopRepositoryInterface::class, 
            ShopRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class, 
            UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
