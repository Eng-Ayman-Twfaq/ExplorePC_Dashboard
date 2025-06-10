<?php

// namespace App\Providers;
use App\Http\Controllers\YourFolder\ProductController;
use Illuminate\Routing\Route;
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
        Route::middleware('web')
       ->group(base_path('routes/web.php'));
    }
}
