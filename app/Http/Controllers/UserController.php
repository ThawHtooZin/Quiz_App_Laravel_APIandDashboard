<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('quizResults')
            ->withAvg('quizResults', 'score')
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['quizResults.quiz']);
        
        $stats = [
            'total_quizzes_taken' => $user->quizResults()->count(),
            'average_score' => $user->quizResults()->count() > 0 ? round($user->quizResults()->avg('score'), 2) : 0,
            'best_score' => $user->quizResults()->max('score') ?? 0,
            'total_time_spent' => $user->quizResults()->sum('time_taken') ?? 0,
        ];

        $recentResults = $user->quizResults()
            ->with('quiz')
            ->latest()
            ->take(10)
            ->get();

        return view('users.show', compact('user', 'stats', 'recentResults'));
    }

    public function results()
    {
        $results = QuizResult::with(['user', 'quiz'])
            ->latest()
            ->paginate(15);

        return view('users.results', compact('results'));
    }

    public function toggleBan(User $user)
    {
        $user->update(['is_banned' => !$user->is_banned]);

        $status = $user->is_banned ? 'banned' : 'unbanned';
        
        return redirect()->route('users.index')
            ->with('success', "User {$status} successfully!");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully!');
    }
}
