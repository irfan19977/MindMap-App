<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\MateriController;
use App\Http\Controllers\Frontend\KelasController;
use App\Http\Controllers\ThemeController;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/about', function () {
    return view('frontend.about');
});
Route::get('/detailk', function () {
    return view('frontend.kelas-detail');
});



Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');

// Kelas detail routes
Route::get('/kelas/{slug}', [KelasController::class, 'show'])->name('kelas.show');
Route::get('/kelas/{category}/{slug}', [KelasController::class, 'showBySubCategory'])->name('kelas.show.sub');

Route::get('/mindmap', function () {
    return view('frontend.mindmap');
});

Route::get('/mindmap/{slug}', [KelasController::class, 'showMindmap'])->name('mindmap.show');

Route::get('/materi/{slug}', function ($slug) {
    return view('frontend.materi-detail', ['slug' => $slug]);
});

Route::get('/contact', function () {
    return view('frontend.contact');
});


Route::middleware('auth')->group(function () {
   Route::resource('dashboard', DashboardController::class);

   Route::resource('categories', CategoriesController::class);
   Route::resource('materis', MateriController::class);

   // AJAX route for materi status update
   Route::patch('/materis/{materi}/status', [MateriController::class, 'updateStatus'])->name('materis.updateStatus');

   // Theme preferences routes
   Route::get('/theme/preferences', [ThemeController::class, 'getPreferences'])->name('theme.getPreferences');
   Route::post('/theme/preferences', [ThemeController::class, 'savePreferences'])->name('theme.savePreferences');
   Route::post('/theme/apply', [ThemeController::class, 'applyPreferences'])->name('theme.applyPreferences');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
