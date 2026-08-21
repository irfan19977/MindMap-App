<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\User;
use App\Models\ClassEnrollment;
use App\Models\CourseClass;

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

        View::composer('backend.layouts.sidebar', function ($view) {
            $pendingTeachers = 0;
            $pendingEnrollments = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $isTeacher = $user->hasRole('teacher');

                if ($isTeacher) {
                    $teacher = $user->teacher;
                    if ($teacher) {
                        $pendingEnrollments = ClassEnrollment::whereIn('class_id',
                            CourseClass::where('teacher_id', $teacher->id)->pluck('id'))
                            ->where('status', 'pending')
                            ->count();
                    }
                } else {
                    $pendingTeachers = User::role('teacher')
                        ->where('teacher_verification_status', 'pending')
                        ->count();
                    $pendingEnrollments = ClassEnrollment::where('status', 'pending')->count();
                }
            }

            $view->with([
                'pendingTeachers' => $pendingTeachers,
                'pendingEnrollments' => $pendingEnrollments
            ]);
        });
    }
}
