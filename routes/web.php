<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\SubcategoriesController;
use App\Http\Controllers\Backend\MateriController;
use App\Http\Controllers\Backend\MindmapController;
use App\Http\Controllers\Backend\LearningResultsController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AnalyticsController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\Frontend\KelasController;
use App\Http\Controllers\Frontend\QuizController as FrontendQuizController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentProfileController;


/*
|--------------------------------------------------------------------------
| Halaman Statis (Frontend)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('frontend.index'); });
Route::get('/about', function () { return view('frontend.about'); });
Route::get('/contact', function () { return view('frontend.contact'); });
Route::get('/detailk', function () { return view('frontend.kelas-detail'); });

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [TeacherController::class, 'index'])->name('index');
    Route::get('/{slug}', [TeacherController::class, 'show'])->name('show');
    Route::get('/{slug}/reviews', [TeacherController::class, 'reviews'])->name('reviews');
    Route::get('/{slug}/courses', [TeacherController::class, 'courses'])->name('courses');
});

/*
|--------------------------------------------------------------------------
| Kelas & Materi Routes
|--------------------------------------------------------------------------
*/
Route::prefix('kelas')->name('kelas.')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('index');
    Route::get('/{slug}', [KelasController::class, 'show'])->name('show');
    Route::get('/{category}/{slug}', [KelasController::class, 'showBySubCategory'])->name('show.sub');
});

Route::get('/mindmap/{slug}', [KelasController::class, 'showMindmap'])->name('mindmap.show');
Route::get('/materi/{slug}', [KelasController::class, 'showMateri'])->name('materi.show');

/*
|--------------------------------------------------------------------------
| API Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('/api/user-progress', [KelasController::class, 'getUserProgress'])->name('api.user-progress');
Route::post('/api/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
Route::get('/api/ai/history', [AIController::class, 'getHistory'])->name('ai.history');

/*
|--------------------------------------------------------------------------
| Backend Routes (Admin & Teacher)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|teacher'])->group(function () {
    Route::resource('dashboard', DashboardController::class);

    // Konten Edukasi
    Route::resource('categories', CategoriesController::class);
    Route::resource('subcategories', SubcategoriesController::class);
    Route::resource('materis', MateriController::class);
    Route::patch('/materis/{materi}/status', [MateriController::class, 'updateStatus'])->name('materis.updateStatus');
    Route::post('/materis/convert-pdf', [MateriController::class, 'convertPdf'])->name('materis.convertPdf');

    // Quiz
    Route::resource('quizzes', QuizController::class);

    // MindMap Creator
    Route::prefix('mindmap-creator')->group(function () {
        Route::get('/', [MindmapController::class, 'index'])->name('mindmap.index');
        Route::get('/materials', [MindmapController::class, 'getMaterials'])->name('mindmap.materials');
        Route::get('/load', [MindmapController::class, 'loadMindmap'])->name('mindmap.load');
        Route::post('/save', [MindmapController::class, 'saveMindmap'])->name('mindmap.save');
    });

    // Hasil Pembelajaran
    Route::prefix('learning-results')->name('learning-results.')->group(function () {
        Route::get('/', [LearningResultsController::class, 'index'])->name('index');
        Route::get('/quizzes', [LearningResultsController::class, 'quizzes'])->name('quizzes');
    });

    // Analytics Dashboard
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/data', [AnalyticsController::class, 'getData'])->name('data');
    });

    // Manajemen Pengguna
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    // Tema
    Route::prefix('theme')->name('theme.')->group(function () {
        Route::get('/preferences', [ThemeController::class, 'getPreferences'])->name('getPreferences');
        Route::post('/preferences', [ThemeController::class, 'savePreferences'])->name('savePreferences');
        Route::post('/apply', [ThemeController::class, 'applyPreferences'])->name('applyPreferences');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/student/profile', [StudentProfileController::class, 'show'])->name('student.profile');

    // Frontend Quiz Routes
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/', [FrontendQuizController::class, 'index'])->name('index');
        Route::get('/take/{quizId}', [FrontendQuizController::class, 'take'])->name('take');
        Route::get('/result/{attemptId}', [FrontendQuizController::class, 'result'])->name('result');
        Route::get('/history/{quizId}', [FrontendQuizController::class, 'history'])->name('history');
        Route::get('/leaderboard/{quizId}', [FrontendQuizController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/progress', [FrontendQuizController::class, 'progress'])->name('progress');
    });

    // Quiz API Routes
    Route::prefix('api/quiz')->group(function () {
        Route::post('/start', [QuizAttemptController::class, 'start'])->name('quiz.start');
        Route::post('/submit', [QuizAttemptController::class, 'submit'])->name('quiz.submit');
        Route::post('/answer', [QuizAttemptController::class, 'submitAnswer'])->name('quiz.answer');
        Route::get('/attempt/{attemptId}', [QuizAttemptController::class, 'show'])->name('quiz.attempt.show');
        Route::get('/{quizId}/attempts', [QuizAttemptController::class, 'getAttemptsByQuiz'])->name('quiz.attempts');
        Route::get('/statistics', [QuizAttemptController::class, 'getStatistics'])->name('quiz.statistics');
        Route::get('/{quizId}/leaderboard', [QuizAttemptController::class, 'getLeaderboard'])->name('quiz.leaderboard');
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-read', [NotificationController::class, 'clearRead'])->name('clear-read');
    });
});

require __DIR__.'/auth.php';
