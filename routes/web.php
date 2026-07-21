<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Artisan;
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
use App\Http\Controllers\Frontend\KelasController;
use App\Http\Controllers\Frontend\QuizController;
<<<<<<< HEAD
use App\Http\Controllers\Backend\ThemeController;
use App\Http\Controllers\Frontend\AIController;
use App\Http\Controllers\Frontend\TeacherController;
use App\Http\Controllers\Frontend\StudentProfileController;
use App\Http\Controllers\Backend\EngagementController;
use App\Http\Controllers\Backend\HelpController;
use App\Http\Controllers\Backend\CourseClassController;
use App\Http\Controllers\Backend\ProfileController as BackendProfileController;
use App\Http\Controllers\Backend\ReportController;
=======
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Backend\EngagementController;

use App\Http\Controllers\PracticeAnswerController;
>>>>>>> 78bdc598ddbf41bef6c09c132d718564328353e1
use App\Http\Controllers\QuizAttemptController;

/*
|--------------------------------------------------------------------------
| Temporary Cache Clear (remove after deployment)
|--------------------------------------------------------------------------
*/
Route::get('/clear', function () {
    if (request('key') !== 'gantirahasia') {
        abort(403, 'Forbidden');
    }

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return 'Cache cleared successfully';
});

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
    
    // Teacher Collaboration (requires auth and teacher role)
    Route::middleware(['auth', 'teacher'])->group(function () {
        Route::get('/collaborations', [\App\Http\Controllers\Frontend\TeacherCollaborationController::class, 'index'])->name('collaborations.index');
        Route::post('/collaborations/{collaboration}/accept', [\App\Http\Controllers\Frontend\TeacherCollaborationController::class, 'accept'])->name('collaborations.accept');
        Route::post('/collaborations/{collaboration}/reject', [\App\Http\Controllers\Frontend\TeacherCollaborationController::class, 'reject'])->name('collaborations.reject');
    });
});

/*
|--------------------------------------------------------------------------
| Kelas & Materi Routes
|--------------------------------------------------------------------------
*/
Route::prefix('kelas')->name('kelas.')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('index');
    Route::get('/{slug}', [KelasController::class, 'show'])->name('show');
    Route::post('/{slug}/join', [KelasController::class, 'joinClass'])->name('join');
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
Route::post('/api/ai/grade-essay', [AIController::class, 'gradeEssay'])->name('ai.grade-essay');
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
   // Engagement dashboard routes
   Route::get('/engagement', [EngagementController::class, 'index'])->name('engagement.index');
   Route::get('/engagement/analytics', [EngagementController::class, 'analytics'])->name('engagement.analytics');
   Route::get('/engagement/user-activity', [EngagementController::class, 'userActivity'])->name('engagement.user-activity');
   Route::get('/engagement/retention', [EngagementController::class, 'retention'])->name('engagement.retention');
   Route::get('/engagement/content-performance', [EngagementController::class, 'contentPerformance'])->name('engagement.content-performance');
   Route::get('/engagement/export', [EngagementController::class, 'export'])->name('engagement.export');
   Route::get('/engagement/activity-feed', [EngagementController::class, 'activityFeed'])->name('engagement.activity-feed');
   Route::get('/engagement/heatmap', [EngagementController::class, 'heatmap'])->name('engagement.heatmap');
   Route::get('/engagement/funnel-analysis', [EngagementController::class, 'funnelAnalysis'])->name('engagement.funnel-analysis');
   Route::get('/engagement/geographic', [EngagementController::class, 'geographicDistribution'])->name('engagement.geographic');
   Route::get('/engagement/user-journey', [EngagementController::class, 'userJourney'])->name('engagement.user-journey');
   Route::get('/engagement/live-online', [EngagementController::class, 'liveOnlineUsers'])->name('engagement.live-online');
   Route::get('/engagement/segmentation', [EngagementController::class, 'userSegmentation'])->name('engagement.segmentation');
   Route::get('/engagement/alerts', [EngagementController::class, 'alerts'])->name('engagement.alerts');
   Route::get('/engagement/custom-range', [EngagementController::class, 'customRangeAnalytics'])->name('engagement.custom-range');

   // Pusat Bantuan
   Route::get('/help', [HelpController::class, 'index'])->name('help.index');

   // Profil Backend
   Route::prefix('backend/profile')->name('backend.profile.')->group(function () {
       Route::get('/', [BackendProfileController::class, 'show'])->name('show');
       Route::patch('/', [BackendProfileController::class, 'update'])->name('update');
       Route::put('/password', [BackendProfileController::class, 'updatePassword'])->name('password');
   });

   // Report
   Route::prefix('reports')->name('reports.')->group(function () {
       Route::get('/users', [ReportController::class, 'users'])->name('users');
       Route::get('/mindmaps', [ReportController::class, 'mindmaps'])->name('mindmaps');
       Route::get('/activities', [ReportController::class, 'activities'])->name('activities');
       Route::get('/export/{type}', [ReportController::class, 'export'])->name('export');
   });

   // Engagement dashboard routes
   Route::get('/engagement', [EngagementController::class, 'index'])->name('engagement.index');
   Route::get('/engagement/analytics', [EngagementController::class, 'analytics'])->name('engagement.analytics');
   Route::get('/engagement/user-activity', [EngagementController::class, 'userActivity'])->name('engagement.user-activity');
   Route::get('/engagement/retention', [EngagementController::class, 'retention'])->name('engagement.retention');
   Route::get('/engagement/content-performance', [EngagementController::class, 'contentPerformance'])->name('engagement.content-performance');
   Route::get('/engagement/export', [EngagementController::class, 'export'])->name('engagement.export');
   Route::get('/engagement/activity-feed', [EngagementController::class, 'activityFeed'])->name('engagement.activity-feed');
   Route::get('/engagement/heatmap', [EngagementController::class, 'heatmap'])->name('engagement.heatmap');
   Route::get('/engagement/funnel-analysis', [EngagementController::class, 'funnelAnalysis'])->name('engagement.funnel-analysis');
   Route::get('/engagement/geographic', [EngagementController::class, 'geographicDistribution'])->name('engagement.geographic');
   Route::get('/engagement/user-journey', [EngagementController::class, 'userJourney'])->name('engagement.user-journey');
   Route::get('/engagement/live-online', [EngagementController::class, 'liveOnlineUsers'])->name('engagement.live-online');
   Route::get('/engagement/segmentation', [EngagementController::class, 'userSegmentation'])->name('engagement.segmentation');
   Route::get('/engagement/alerts', [EngagementController::class, 'alerts'])->name('engagement.alerts');
   Route::get('/engagement/custom-range', [EngagementController::class, 'customRangeAnalytics'])->name('engagement.custom-range');

   Route::resource('categories', CategoriesController::class);
   Route::resource('subcategories', SubcategoriesController::class);
   Route::resource('materis', MateriController::class);

    // Kelas
    Route::get('/classes/materials', [CourseClassController::class, 'getMaterials'])->name('classes.materials');
    Route::post('/classes/{courseClass}/sync-materials', [CourseClassController::class, 'syncMaterials'])->name('classes.sync-materials');
    Route::patch('/classes/{courseClass}/enrollments/{enrollment}/approve', [CourseClassController::class, 'approveEnrollment'])->name('classes.enrollments.approve');
    Route::patch('/classes/{courseClass}/enrollments/{enrollment}/reject', [CourseClassController::class, 'rejectEnrollment'])->name('classes.enrollments.reject');
    Route::resource('classes', CourseClassController::class)->parameters([
        'classes' => 'courseClass',
    ]);

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

    // Kolaborasi - custom routes must be defined before Route::resource
    Route::get('/classes/{courseClass}/collaboration', [\App\Http\Controllers\Backend\CollaborationController::class, 'classCollaboration'])->name('classes.collaboration');
    Route::get('/collaborations/subcategories', [\App\Http\Controllers\Backend\CollaborationController::class, 'getSubcategories'])->name('collaborations.subcategories');
    Route::get('/collaborations/classes', [\App\Http\Controllers\Backend\CollaborationController::class, 'getClasses'])->name('collaborations.classes');
    Route::post('/collaborations/quick-invite', [\App\Http\Controllers\Backend\CollaborationController::class, 'quickInvite'])->name('collaborations.quickInvite');
    Route::post('/collaborations/{collaboration}/revoke', [\App\Http\Controllers\Backend\CollaborationController::class, 'revoke'])->name('collaborations.revoke');
    Route::resource('collaborations', \App\Http\Controllers\Backend\CollaborationController::class);

    // Kolaborasi - Teacher Inbox
    Route::get('/my-collaborations', [\App\Http\Controllers\Backend\CollaborationController::class, 'myCollaborations'])->name('collaborations.my');
    Route::post('/my-collaborations/{collaboration}/accept', [\App\Http\Controllers\Backend\CollaborationController::class, 'acceptCollaboration'])->name('collaborations.my.accept');
    Route::post('/my-collaborations/{collaboration}/reject', [\App\Http\Controllers\Backend\CollaborationController::class, 'rejectCollaboration'])->name('collaborations.my.reject');

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
    Route::get('/student/profile/edit', [StudentProfileController::class, 'edit'])->name('student.profile.edit');
    Route::put('/student/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');

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