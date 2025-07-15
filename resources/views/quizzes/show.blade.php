@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="space-y-6">
    <!-- Quiz Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
            </div>
            <div class="text-right">
                @if($quiz->is_published)
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Published</span>
                @else
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Draft</span>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $quiz->questions_count }}</div>
                <div class="text-sm text-gray-600">Questions</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $quiz->total_attempts }}</div>
                <div class="text-sm text-gray-600">Attempts</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $quiz->average_score }}</div>
                <div class="text-sm text-gray-600">Avg Score</div>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</div>
                <div class="text-sm text-gray-600">Time Limit</div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('quizzes.questions.index', $quiz) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                Manage Questions
            </a>
            <a href="{{ route('quizzes.edit', $quiz) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Edit Quiz
            </a>
            <form action="{{ route('quizzes.toggle-publish', $quiz) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium">
                    {{ $quiz->is_published ? 'Unpublish' : 'Publish' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Recent Results -->
    @if($quiz->quizResults->count() > 0)
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Results</h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($quiz->quizResults->take(10) as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->score }}/{{ $quiz->questions_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->percentage }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->formatted_time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 