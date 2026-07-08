<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Mindmap;
use App\Models\QuizAttempt;
use App\Models\SiteVisit;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ReportController extends Controller
{
    /**
     * Report data pengguna.
     */
    public function users(Request $request)
    {
        $query = User::with('roles')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search);
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $users = $query->get();

        $stats = [
            'total' => User::count(),
            'active' => User::where('last_login_at', '>=', now()->subDays(7))->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        $roles = Role::all();

        return view('backend.reports.users', compact('users', 'stats', 'roles'));
    }

    /**
     * Report data mindmap.
     */
    public function mindmaps(Request $request)
    {
        $query = Mindmap::with(['creator', 'category', 'subcategory'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('title', 'like', $search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $mindmaps = $query->get();

        $stats = [
            'total' => Mindmap::count(),
            'publish' => Mindmap::where('status', 'publish')->count(),
            'draft' => Mindmap::where('status', 'draft')->count(),
            'inactive' => Mindmap::where('status', 'inactive')->count(),
        ];

        return view('backend.reports.mindmaps', compact('mindmaps', 'stats'));
    }

    /**
     * Report aktivitas platform.
     */
    public function activities(Request $request)
    {
        $type = $request->get('type', 'login');

        $startDate = $request->filled('start_date') ? $request->start_date : now()->subDays(30)->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : now()->format('Y-m-d');

        $logins = collect();
        $quizAttempts = collect();
        $progress = collect();
        $visits = collect();

        if ($type === 'login') {
            $logins = User::whereNotNull('last_login_at')
                ->whereDate('last_login_at', '>=', $startDate)
                ->whereDate('last_login_at', '<=', $endDate)
                ->orderBy('last_login_at', 'desc')
                ->get();
        } elseif ($type === 'quiz') {
            $quizAttempts = QuizAttempt::with(['user', 'quiz'])
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($type === 'learning') {
            $progress = UserProgress::with(['user', 'material'])
                ->whereDate('updated_at', '>=', $startDate)
                ->whereDate('updated_at', '<=', $endDate)
                ->orderBy('updated_at', 'desc')
                ->get();
        } elseif ($type === 'visit') {
            $visits = SiteVisit::with('user')
                ->whereDate('visited_date', '>=', $startDate)
                ->whereDate('visited_date', '<=', $endDate)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $stats = [
            'logins_today' => User::whereDate('last_login_at', today())->count(),
            'logins_week' => User::where('last_login_at', '>=', now()->startOfWeek())->count(),
            'logins_month' => User::whereMonth('last_login_at', now()->month)
                ->whereYear('last_login_at', now()->year)
                ->count(),
            'quiz_today' => QuizAttempt::whereDate('created_at', today())->count(),
            'quiz_week' => QuizAttempt::where('created_at', '>=', now()->startOfWeek())->count(),
            'quiz_month' => QuizAttempt::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'completed_today' => UserProgress::whereDate('completed_at', today())->count(),
            'completed_week' => UserProgress::where('completed_at', '>=', now()->startOfWeek())->count(),
            'completed_month' => UserProgress::whereMonth('completed_at', now()->month)
                ->whereYear('completed_at', now()->year)
                ->count(),
            'visits_today' => SiteVisit::whereDate('visited_date', today())->count(),
            'visits_week' => SiteVisit::where('visited_date', '>=', now()->startOfWeek())->count(),
            'visits_month' => SiteVisit::whereMonth('visited_date', now()->month)
                ->whereYear('visited_date', now()->year)
                ->count(),
        ];

        return view('backend.reports.activities', compact(
            'type', 'startDate', 'endDate', 'logins', 'quizAttempts', 'progress', 'visits', 'stats'
        ));
    }

    /**
     * Export report data ke CSV.
     */
    public function export(Request $request, string $type)
    {
        $format = $request->get('format', 'csv');
        $data = collect();
        $filename = "report_{$type}_" . now()->format('Y-m-d') . '.csv';

        switch ($type) {
            case 'users':
                $data = User::with('roles')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'ID' => $user->id,
                            'Name' => $user->name,
                            'Email' => $user->email,
                            'Roles' => $user->roles->pluck('name')->implode(', '),
                            'Last Login' => $user->last_login_at?->format('Y-m-d H:i:s'),
                            'Registered' => $user->created_at?->format('Y-m-d H:i:s'),
                        ];
                    });
                break;

            case 'mindmaps':
                $data = Mindmap::with(['creator', 'category', 'subcategory'])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($mindmap) {
                        return [
                            'ID' => $mindmap->id,
                            'Title' => $mindmap->title,
                            'Reference' => $mindmap->category?->name ?? $mindmap->subcategory?->name ?? '-',
                            'Status' => $mindmap->status,
                            'Creator' => $mindmap->creator?->name ?? '-',
                            'Created' => $mindmap->created_at?->format('Y-m-d H:i:s'),
                        ];
                    });
                break;

            case 'activities':
                $data = User::whereNotNull('last_login_at')
                    ->orderBy('last_login_at', 'desc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'User' => $user->name,
                            'Email' => $user->email,
                            'Activity' => 'Login',
                            'Time' => $user->last_login_at?->format('Y-m-d H:i:s'),
                        ];
                    });
                break;

            default:
                abort(404);
        }

        if ($format === 'json') {
            return response()->json($data);
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()));
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
