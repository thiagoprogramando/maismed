<?php

namespace App\Providers;

use App\Models\Unit;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider {

    public function register(): void {
        
    }

    public function boot(): void {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            
            $units = Unit::orderBy('name', 'asc')->get();
            $view->with(['units_extend' => $units]);
        });
    }
}
