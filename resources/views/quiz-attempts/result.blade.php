@extends('layouts.app')

@section('title', 'Quiz Result - ' . $quizResult->quiz->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Result Summary -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Quiz Complete!</h1>
            <p class="text-gray-600 mb-6">{{ $quizResult->quiz->title }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $quizResult->score }}/{{ $quizResult->quiz->questions->count() }}</div>
                    <div class="text-sm text-gray-600">Score</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $quizResult->percentage }}%</div>
                    <div class="text-sm text-gray-600">Percentage</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ $quizResult->formatted_time }}</div>
                    <div class="text-sm text-gray-600">Time Taken</div>
                </div>
            </div>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('quiz-attempts.history') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium">
                    View History
                </a>
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Detailed Results -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Question Review</h2>
        </div>
        
        <div class="p-6 space-y-6">
            @foreach($quizResult->quiz->questions as $index => $question)
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Question {{ $index + 1 }}</h3>
                    @php
                        $userAnswer = $quizResult->answers->where('question_id', $question->id)->first();
                        $isCorrect = $userAnswer ? $userAnswer->is_correct : false;
                    @endphp
                    @if($isCorrect)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Correct
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Incorrect
                        </span>
                    @endif
                </div>
                
                <p class="text-gray-900 mb-4">{{ $question->question_text }}</p>
                
                <div class="space-y-2">
                    @foreach($question->options as $option)
                    <div class="flex items-center p-3 rounded-lg 
                        @if($option->is_correct) bg-green-50 border border-green-200 @elseif($userAnswer && $userAnswer->selected_option_id == $option->id && !$option->is_correct) bg-red-50 border border-red-200 @else bg-gray-50 border border-gray-200 @endif">
                        <div class="flex items-center">
                            @if($option->is_correct)
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($userAnswer && $userAnswer->selected_option_id == $option->id && !$option->is_correct)
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @else
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3"></div>
                            @endif
                            <span class="text-gray-900">{{ $option->text }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 