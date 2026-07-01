<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class EngagementController extends Controller
{
    /**
     * Display the engagement dashboard.
     */
    public function index()
    {
        // Get overall engagement metrics
        $totalUsers = User::count();
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(7))->count();
        $totalCategories = Category::count();
        $totalSubcategories = Subcategory::count();
        $totalMateris = Material::count();

        // Get user growth data (last 30 days)
        $userGrowth = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get activity by category
        $categoryActivity = Category::withCount('subcategories', 'materis')
            ->orderBy('materis_count', 'desc')
            ->limit(10)
            ->get();

        // Get recent user activity
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get engagement metrics by day (last 7 days)
        $dailyEngagement = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyEngagement[] = [
                'date' => $date,
                'new_users' => User::whereDate('created_at', $date)->count(),
                'active_users' => User::whereDate('last_login_at', $date)->count(),
            ];
        }

        return view('backend.engagement.index', compact(
            'totalUsers',
            'activeUsers',
            'totalCategories',
            'totalSubcategories',
            'totalMateris',
            'userGrowth',
            'categoryActivity',
            'recentUsers',
            'dailyEngagement'
        ));
    }

    /**
     * Get detailed engagement analytics.
     */
    public function analytics(Request $request)
    {
        $period = $request->get('period', '7'); // default 7 days

        $startDate = now()->subDays($period);
        
        // Get various engagement metrics
        $metrics = [
            'user_registrations' => User::where('created_at', '>=', $startDate)->count(),
            'active_sessions' => User::where('last_login_at', '>=', $startDate)->count(),
            'new_categories' => Category::where('created_at', '>=', $startDate)->count(),
            'new_materis' => Material::where('created_at', '>=', $startDate)->count(),
        ];

        return response()->json($metrics);
    }

    /**
     * Get user activity data for charts.
     */
    public function userActivity(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        $startDate = now()->subDays($period);

        $activity = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as registrations')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($activity);
    }

    /**
     * Get user retention metrics.
     */
    public function retention(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        
        // Calculate retention rates by cohort
        $retentionData = [];
        
        for ($i = 0; $i < $period; $i++) {
            $cohortDate = now()->subDays($i)->format('Y-m-d');
            $cohortUsers = User::whereDate('created_at', $cohortDate)->get();
            
            if ($cohortUsers->count() > 0) {
                $activeAfter7Days = $cohortUsers->where('last_login_at', '>=', now()->subDays($i + 7))->count();
                $activeAfter30Days = $cohortUsers->where('last_login_at', '>=', now()->subDays($i + 30))->count();
                
                $retentionData[] = [
                    'date' => $cohortDate,
                    'cohort_size' => $cohortUsers->count(),
                    'retention_7d' => round(($activeAfter7Days / $cohortUsers->count()) * 100, 2),
                    'retention_30d' => round(($activeAfter30Days / $cohortUsers->count()) * 100, 2),
                ];
            }
        }

        return response()->json($retentionData);
    }

    /**
     * Get content performance metrics.
     */
    public function contentPerformance(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        $startDate = now()->subDays($period);

        // Get most viewed categories
        $topCategories = Category::withCount('materis')
            ->orderBy('materis_count', 'desc')
            ->limit(10)
            ->get();

        // Get content creation trends
        $contentTrends = Material::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get category distribution
        $categoryDistribution = Category::with('subcategories')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'materis_count' => $category->materis()->count(),
                    'subcategories_count' => $category->subcategories()->count(),
                ];
            });

        return response()->json([
            'top_categories' => $topCategories,
            'content_trends' => $contentTrends,
            'category_distribution' => $categoryDistribution,
        ]);
    }

    /**
     * Export analytics data.
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'analytics');
        $format = $request->get('format', 'csv');
        
        $data = [];
        
        switch ($type) {
            case 'users':
                $data = User::select('id', 'name', 'email', 'created_at', 'last_login_at')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 'categories':
                $data = Category::withCount('subcategories', 'materis')
                    ->get();
                break;
            case 'analytics':
            default:
                $data = [
                    'total_users' => User::count(),
                    'active_users' => User::where('last_login_at', '>=', now()->subDays(7))->count(),
                    'total_categories' => Category::count(),
                    'total_materis' => Material::count(),
                    'export_date' => now()->format('Y-m-d H:i:s'),
                ];
                break;
        }

        if ($format === 'json') {
            return response()->json($data);
        }

        // CSV export
        $filename = "engagement_{$type}_" . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data, $type) {
            $file = fopen('php://output', 'w');
            
            if (is_array($data) && isset($data['total_users'])) {
                // Analytics summary
                fputcsv($file, array_keys($data));
                fputcsv($file, array_values($data));
            } elseif ($data->count() > 0) {
                // Collection data
                fputcsv($file, array_keys($data->first()->toArray()));
                foreach ($data as $item) {
                    fputcsv($file, $item->toArray());
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get real-time activity feed.
     */
    public function activityFeed(Request $request)
    {
        $limit = $request->get('limit', 20);
        
        // Get recent activities (simulated - in real app, use activity logging)
        $activities = collect([
            [
                'type' => 'user_registration',
                'message' => 'New user registered',
                'user' => User::latest()->first()?->name ?? 'Unknown',
                'time' => now()->diffForHumans(),
                'icon' => 'user-plus',
                'color' => 'success',
            ],
            [
                'type' => 'content_created',
                'message' => 'New material created',
                'user' => 'Admin',
                'time' => now()->subMinutes(5)->diffForHumans(),
                'icon' => 'file-plus',
                'color' => 'primary',
            ],
            [
                'type' => 'category_updated',
                'message' => 'Category updated',
                'user' => 'Teacher',
                'time' => now()->subMinutes(15)->diffForHumans(),
                'icon' => 'folder',
                'color' => 'warning',
            ],
        ]);

        return response()->json($activities->take($limit));
    }

    /**
     * Get heatmap data for user activity by hour and day.
     */
    public function heatmap(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        $startDate = now()->subDays($period);

        // Initialize heatmap data (7 days x 24 hours)
        $heatmapData = [];
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        for ($day = 0; $day < 7; $day++) {
            for ($hour = 0; $hour < 24; $hour++) {
                $heatmapData[$days[$day]][$hour] = 0;
            }
        }

        // Get user activity by day and hour
        $userActivity = User::select(
            DB::raw('DAYOFWEEK(last_login_at) as day_of_week'),
            DB::raw('HOUR(last_login_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->where('last_login_at', '>=', $startDate)
            ->whereNotNull('last_login_at')
            ->groupBy('day_of_week', 'hour')
            ->get();

        // Fill heatmap data
        foreach ($userActivity as $activity) {
            $dayIndex = ($activity->day_of_week + 6) % 7; // Convert to 0-6 (Sunday-Saturday)
            $dayName = $days[$dayIndex];
            $heatmapData[$dayName][$activity->hour] = $activity->count;
        }

        return response()->json($heatmapData);
    }

    /**
     * Get funnel analysis data.
     */
    public function funnelAnalysis(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        $startDate = now()->subDays($period);

        // Funnel stages
        $funnel = [
            [
                'stage' => 'Registrations',
                'count' => User::where('created_at', '>=', $startDate)->count(),
                'description' => 'Users who signed up'
            ],
            [
                'stage' => 'First Login',
                'count' => User::where('created_at', '>=', $startDate)
                    ->whereNotNull('last_login_at')
                    ->count(),
                'description' => 'Users who logged in at least once'
            ],
            [
                'stage' => 'Active Users (7d)',
                'count' => User::where('created_at', '>=', $startDate)
                    ->where('last_login_at', '>=', now()->subDays(7))
                    ->count(),
                'description' => 'Users active in last 7 days'
            ],
            [
                'stage' => 'Content Engagement',
                'count' => User::where('created_at', '>=', $startDate)
                    ->where('last_login_at', '>=', now()->subDays(7))
                    ->whereHas('userProgress')
                    ->count(),
                'description' => 'Users who engaged with content'
            ],
        ];

        // Calculate conversion rates
        $totalCount = $funnel[0]['count'];
        foreach ($funnel as &$stage) {
            $stage['conversion_rate'] = $totalCount > 0 
                ? round(($stage['count'] / $totalCount) * 100, 2) 
                : 0;
            $stage['drop_off'] = $totalCount > 0 
                ? round((($totalCount - $stage['count']) / $totalCount) * 100, 2) 
                : 0;
        }

        return response()->json($funnel);
    }

    /**
     * Get geographic distribution of users.
     */
    public function geographicDistribution(Request $request)
    {
        // Since we don't have location data, we'll simulate with user patterns
        // In real app, use IP geolocation or user-provided location
        
        $geoData = User::select(
            DB::raw('SUBSTRING_INDEX(email, "@", -1) as domain'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('domain')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                // Simulate country based on email domain
                $country = 'Unknown';
                if (str_contains($item->domain, '.id')) $country = 'Indonesia';
                elseif (str_contains($item->domain, '.com')) $country = 'United States';
                elseif (str_contains($item->domain, '.my')) $country = 'Malaysia';
                elseif (str_contains($item->domain, '.sg')) $country = 'Singapore';
                elseif (str_contains($item->domain, '.edu')) $country = 'Educational';
                
                return [
                    'country' => $country,
                    'domain' => $item->domain,
                    'count' => $item->count,
                ];
            });

        return response()->json($geoData);
    }

    /**
     * Get user journey mapping data.
     */
    public function userJourney(Request $request)
    {
        $userId = $request->get('user_id');
        
        if ($userId) {
            // Get specific user journey
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $journey = [
                'user' => $user->name,
                'registered' => $user->created_at->format('Y-m-d H:i:s'),
                'first_login' => $user->last_login_at?->format('Y-m-d H:i:s') ?? 'Never',
                'days_active' => $user->last_login_at 
                    ? $user->created_at->diffInDays($user->last_login_at) 
                    : 0,
                'activities' => [
                    [
                        'action' => 'Registration',
                        'timestamp' => $user->created_at->format('Y-m-d H:i:s'),
                        'status' => 'completed'
                    ],
                    [
                        'action' => 'First Login',
                        'timestamp' => $user->last_login_at?->format('Y-m-d H:i:s') ?? 'N/A',
                        'status' => $user->last_login_at ? 'completed' : 'pending'
                    ],
                ]
            ];

            return response()->json($journey);
        }

        // Get aggregate journey data
        $journeyStats = [
            'avg_time_to_first_login' => User::whereNotNull('last_login_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, last_login_at)) as avg_hours')
                ->value('avg_hours'),
            'users_with_first_login' => User::whereNotNull('last_login_at')->count(),
            'users_without_first_login' => User::whereNull('last_login_at')->count(),
            'avg_session_duration' => 24, // Simulated - in real app, track session duration
        ];

        return response()->json($journeyStats);
    }

    /**
     * Get live online users count.
     */
    public function liveOnlineUsers()
    {
        // Count users who logged in within the last 5 minutes
        $onlineUsers = User::where('last_login_at', '>=', now()->subMinutes(5))->count();
        
        return response()->json([
            'online_count' => $onlineUsers,
            'total_users' => User::count(),
            'timestamp' => now()->format('H:i:s')
        ]);
    }

    /**
     * Get user segmentation data.
     */
    public function userSegmentation(Request $request)
    {
        $period = $request->get('period', '30'); // default 30 days
        $startDate = now()->subDays($period);

        // Define user segments
        $segments = [
            'active' => [
                'label' => 'Active Users',
                'description' => 'Users active in last 7 days',
                'count' => User::where('last_login_at', '>=', now()->subDays(7))->count(),
                'color' => 'success'
            ],
            'at_risk' => [
                'label' => 'At Risk',
                'description' => 'Users not active in 7-30 days',
                'count' => User::where('last_login_at', '>=', now()->subDays(30))
                    ->where('last_login_at', '<', now()->subDays(7))
                    ->count(),
                'color' => 'warning'
            ],
            'churned' => [
                'label' => 'Churned',
                'description' => 'Users not active in 30+ days',
                'count' => User::where('last_login_at', '<', now()->subDays(30))
                    ->orWhereNull('last_login_at')
                    ->count(),
                'color' => 'danger'
            ],
            'new' => [
                'label' => 'New Users',
                'description' => 'Users registered in last 30 days',
                'count' => User::where('created_at', '>=', $startDate)->count(),
                'color' => 'primary'
            ]
        ];

        // Calculate percentages
        $totalUsers = User::count();
        foreach ($segments as &$segment) {
            $segment['percentage'] = $totalUsers > 0 
                ? round(($segment['count'] / $totalUsers) * 100, 2) 
                : 0;
        }

        return response()->json($segments);
    }

    /**
     * Get alerts for anomalies.
     */
    public function alerts(Request $request)
    {
        $alerts = [];
        
        // Alert 1: Significant drop in daily active users
        $todayActive = User::whereDate('last_login_at', today())->count();
        $yesterdayActive = User::whereDate('last_login_at', now()->subDay())->count();
        
        if ($yesterdayActive > 0 && $todayActive < $yesterdayActive * 0.7) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Significant Drop in Active Users',
                'message' => "Daily active users dropped by " . round((1 - $todayActive / $yesterdayActive) * 100, 1) . "% compared to yesterday",
                'timestamp' => now()->format('H:i:s'),
                'icon' => 'alert-triangle'
            ];
        }

        // Alert 2: Low user retention
        $newUsersLastWeek = User::where('created_at', '>=', now()->subDays(7))->count();
        $activeNewUsers = User::where('created_at', '>=', now()->subDays(7))
            ->where('last_login_at', '>=', now()->subDays(7))
            ->count();
        
        if ($newUsersLastWeek > 0 && ($activeNewUsers / $newUsersLastWeek) < 0.5) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'Low User Retention',
                'message' => "Only " . round(($activeNewUsers / $newUsersLastWeek) * 100, 1) . "% of new users from last week are still active",
                'timestamp' => now()->format('H:i:s'),
                'icon' => 'user-x'
            ];
        }

        // Alert 3: No new content in 7 days
        $recentMateri = Material::where('created_at', '>=', now()->subDays(7))->count();
        if ($recentMateri === 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'No New Content',
                'message' => 'No new materials have been created in the last 7 days',
                'timestamp' => now()->format('H:i:s'),
                'icon' => 'file-text'
            ];
        }

        // Alert 4: High user growth (positive alert)
        $newUsersThisWeek = User::where('created_at', '>=', now()->subDays(7))->count();
        $newUsersLastWeek = User::where('created_at', '>=', now()->subDays(14))
            ->where('created_at', '<', now()->subDays(7))
            ->count();
        
        if ($newUsersLastWeek > 0 && $newUsersThisWeek > $newUsersLastWeek * 1.5) {
            $alerts[] = [
                'type' => 'success',
                'title' => 'High User Growth',
                'message' => "User registrations increased by " . round((($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100, 1) . "% compared to last week",
                'timestamp' => now()->format('H:i:s'),
                'icon' => 'trending-up'
            ];
        }

        return response()->json($alerts);
    }

    /**
     * Get analytics data for custom date range.
     */
    public function customRangeAnalytics(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->endOfDay();

        $analytics = [
            'period' => [
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'days' => $start->diffInDays($end) + 1
            ],
            'metrics' => [
                'new_users' => User::whereBetween('created_at', [$start, $end])->count(),
                'active_users' => User::whereBetween('last_login_at', [$start, $end])->count(),
                'new_categories' => Category::whereBetween('created_at', [$start, $end])->count(),
                'new_materis' => Material::whereBetween('created_at', [$start, $end])->count(),
            ],
            'daily_breakdown' => []
        ];

        // Get daily breakdown
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $analytics['daily_breakdown'][] = [
                'date' => $date->format('Y-m-d'),
                'new_users' => User::whereDate('created_at', $date)->count(),
                'active_users' => User::whereDate('last_login_at', $date)->count(),
            ];
        }

        return response()->json($analytics);
    }
}
