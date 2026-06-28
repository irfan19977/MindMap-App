<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\SubcategoriesController;
use App\Http\Controllers\Backend\MateriController;
use App\Http\Controllers\Backend\MindmapController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\KelasController;
use App\Http\Controllers\Frontend\StudentProgressController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AIController;

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

Route::get('/materi/{slug}', [KelasController::class, 'showMateri'])->name('materi.show');

// Student Progress Routes (under Layanan)
Route::middleware('auth')->group(function () {
    Route::get('/layanan/progress-tracking', [StudentProgressController::class, 'index'])->name('layanan.progress-tracking');
    Route::get('/layanan/progress-tracking/material/{materialId}', [StudentProgressController::class, 'showMaterial'])->name('layanan.progress-tracking.material');
    Route::patch('/layanan/progress-tracking/update/{materialId}', [StudentProgressController::class, 'updateProgress'])->name('layanan.progress-tracking.update');
    Route::get('/layanan/progress-tracking/data', [StudentProgressController::class, 'getProgressData'])->name('layanan.progress-tracking.data');
});

Route::get('/contact', function () {
    return view('frontend.contact');
});

// AI Chat endpoint
Route::post('/api/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
Route::get('/api/ai/history', [AIController::class, 'getHistory'])->name('ai.history');


Route::middleware('auth')->group(function () {
   Route::resource('dashboard', DashboardController::class);

   Route::resource('categories', CategoriesController::class);
   Route::resource('subcategories', SubcategoriesController::class);
   Route::resource('materis', MateriController::class);

   // Role, Permission, and User management routes
   Route::resource('roles', RoleController::class);
   Route::resource('permissions', PermissionController::class);
   Route::resource('users', UserController::class);

   // Mind map routes
   Route::get('/mindmap-creator', [MindmapController::class, 'index'])->name('mindmap.index');
   Route::get('/mindmap-creator/materials', [MindmapController::class, 'getMaterials'])->name('mindmap.materials');
   Route::get('/mindmap-creator/load', [MindmapController::class, 'loadMindmap'])->name('mindmap.load');
   Route::post('/mindmap-creator/save', [MindmapController::class, 'saveMindmap'])->name('mindmap.save');

   // AJAX route for materi status update
   Route::patch('/materis/{materi}/status', [MateriController::class, 'updateStatus'])->name('materis.updateStatus');

   // AJAX route for PDF to text conversion
   Route::post('/materis/convert-pdf', [MateriController::class, 'convertPdf'])->name('materis.convertPdf');

   // Theme preferences routes
   Route::get('/theme/preferences', [ThemeController::class, 'getPreferences'])->name('theme.getPreferences');
   Route::post('/theme/preferences', [ThemeController::class, 'savePreferences'])->name('theme.savePreferences');
   Route::post('/theme/apply', [ThemeController::class, 'applyPreferences'])->name('theme.applyPreferences');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
