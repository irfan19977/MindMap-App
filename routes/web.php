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
use App\Http\Controllers\Frontend\QuizController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\PracticeAnswerController;
use App\Http\Controllers\QuizAttemptController;

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

Route::get('/mindmap/{slug}', [KelasController::class, 'showMindmap'])->name('mindmap.show');

Route::get('/materi/{slug}', [KelasController::class, 'showMateri'])->name('materi.show');
Route::get('/api/user-progress', [KelasController::class, 'getUserProgress'])->name('api.user-progress');

Route::get('/contact', function () {
    return view('frontend.contact');
});

// AI Chat endpoint
Route::post('/api/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
Route::get('/api/ai/history', [AIController::class, 'getHistory'])->name('ai.history');


Route::middleware(['auth', 'role:admin|teacher'])->group(function () {
   Route::resource('dashboard', DashboardController::class);

   Route::resource('categories', CategoriesController::class);
   Route::resource('subcategories', SubcategoriesController::class);
   Route::resource('materis', MateriController::class);

   // Role, Permission, and User management routes
   Route::resource('roles', RoleController::class);
   Route::resource('permissions', PermissionController::class);
   Route::resource('users', UserController::class);

   // Quiz management routes
   Route::resource('quizzes', QuizController::class);

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
});


Route::middleware('auth')->group(function () {

   // Practice answers endpoints
   Route::post('/api/practice/answer', [PracticeAnswerController::class, 'store'])->name('practice.answer');
   Route::get('/api/practice/material/{materialId}/answers', [PracticeAnswerController::class, 'getAnswersByMaterial'])->name('practice.material.answers');
   Route::get('/api/practice/total-score', [PracticeAnswerController::class, 'getTotalScore'])->name('practice.total.score');

   // Quiz endpoints
   Route::post('/api/quiz/start', [QuizAttemptController::class, 'start'])->name('quiz.start');
   Route::post('/api/quiz/submit', [QuizAttemptController::class, 'submit'])->name('quiz.submit');
   Route::post('/api/quiz/answer', [QuizAttemptController::class, 'submitAnswer'])->name('quiz.answer');
   Route::get('/api/quiz/attempt/{attemptId}', [QuizAttemptController::class, 'show'])->name('quiz.attempt.show');
   Route::get('/api/quiz/{quizId}/attempts', [QuizAttemptController::class, 'getAttemptsByQuiz'])->name('quiz.attempts');
   Route::get('/api/quiz/statistics', [QuizAttemptController::class, 'getStatistics'])->name('quiz.statistics');
   Route::get('/api/quiz/{quizId}/leaderboard', [QuizAttemptController::class, 'getLeaderboard'])->name('quiz.leaderboard');

   // Quiz frontend routes
   Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
   Route::get('/quiz/take/{quizId}', [QuizController::class, 'take'])->name('quiz.take');
   Route::get('/quiz/result/{attemptId}', [QuizController::class, 'result'])->name('quiz.result');
   Route::get('/quiz/history/{quizId}', [QuizController::class, 'history'])->name('quiz.history');
   Route::get('/quiz/leaderboard/{quizId}', [QuizController::class, 'leaderboard'])->name('quiz.leaderboard');
   Route::get('/quiz/progress', [QuizController::class, 'progress'])->name('quiz.progress');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
