<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Http\Request;

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
            ->latest()
            ->take(5)
            ->get();

        $recentResults = QuizResult::with(['user', 'quiz'])
            ->latest()
            ->take(10)
            ->get();

        $topQuizzes = Quiz::withCount('quizResults')
            ->orderBy('quiz_results_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentQuizzes', 'recentResults', 'topQuizzes'));
    }
}
