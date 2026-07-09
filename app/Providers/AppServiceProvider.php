<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        View::composer('frontend.layouts.navbar', function ($view) {
            $topIds = DB::table('categories')
                ->select('categories.id', DB::raw('COUNT(user_progress.id) as progress_count'))
                ->join('subcategories', 'subcategories.category_id', '=', 'categories.id')
                ->join('materials', 'materials.subcategory_id', '=', 'subcategories.id')
                ->join('user_progress', 'user_progress.material_id', '=', 'materials.id')
                ->where('categories.status', 'publish')
                ->groupBy('categories.id')
                ->orderByDesc('progress_count')
                ->limit(5)
                ->pluck('categories.id');

            $popularCategories = Category::whereIn('id', $topIds)->get()
                ->sortBy(fn($cat) => array_search($cat->id, $topIds->toArray()));

            $view->with('popularCategories', $popularCategories);
        });
    }
}
