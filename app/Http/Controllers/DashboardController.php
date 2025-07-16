<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_quizzes' => Quiz::count(),
            'published_quizzes' => Quiz::where('is_published', true)->count(),
            'total_users' => User::count(),
            'total_attempts' => QuizResult::count(),
            'average_score' => QuizResult::count() > 0 ? round(QuizResult::avg('score'), 2) : 0,
        ];

        $recentQuizzes = Quiz::withCount(['questions', 'quizResults'])
            ->withAvg('quizResults', 'score')
            ->latest()
            ->take(5)
            ->get();

        $recentResults = QuizResult::with(['user', 'quiz'])
            ->latest()
            ->take(10)
            ->get();

        $topQuizzes = Quiz::withCount('quizResults')
            ->withAvg('quizResults', 'score')
            ->orderBy('quiz_results_count', 'desc')
            ->take(5)
            ->get();

        // Get quiz performance data for charts
        $quizPerformance = Quiz::withCount('quizResults')
            ->withAvg('quizResults', 'score')
            ->whereHas('quizResults')
            ->orderBy('quiz_results_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($quiz) {
                return [
                    'title' => $quiz->title,
                    'avg_score' => round($quiz->quiz_results_avg_score ?? 0, 1),
                    'attempts' => $quiz->quiz_results_count
                ];
            });

        // Get user activity data for the last 7 days
        $userActivity = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $attempts = QuizResult::whereDate('created_at', $date)->count();
            $userActivity->push([
                'date' => $date->format('M d'),
                'attempts' => $attempts
            ]);
        }

        // Get additional statistics
        $additionalStats = [
            'total_questions' => DB::table('questions')->count(),
            'total_options' => DB::table('options')->count(),
            'banned_users' => User::where('is_banned', true)->count(),
            'active_users_today' => User::whereHas('quizResults', function($query) {
                $query->whereDate('created_at', Carbon::today());
            })->count(),
        ];

        return view('dashboard.index', compact(
            'stats', 
            'recentQuizzes', 
            'recentResults', 
            'topQuizzes',
            'quizPerformance',
            'userActivity',
            'additionalStats'
        ));
    }
}
