<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\subCategory;
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
    view()->composer('*', function($view) {
        $subCategories = SubCategory::select(['id', 'name_ckb', 'name_ar', 'name_en', 'category_id'])
            ->with('category:id,name_en') // Optional: if you want category info
            ->get()
            ->each(function($q) {
                $q->setAppends([]);
            });
        $view->with('subCategories', $subCategories);
    });
}
}
