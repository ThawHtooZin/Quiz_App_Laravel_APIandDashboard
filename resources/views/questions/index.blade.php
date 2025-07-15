@extends('layouts.app')

@section('title', 'Questions - ' . $quiz->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Questions for: {{ $quiz->title }}</h1>
            <p class="text-gray-600">{{ $questions->count() }} questions</p>
        </div>
        <a href="{{ route('quizzes.questions.create', $quiz) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
            Add Question
        </a>
    </div>

    <!-- Questions List -->
    <div class="space-y-4">
        @if($questions->count() > 0)
            @foreach($questions as $index => $question)
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Question {{ $index + 1 }}</h3>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('quizzes.questions.edit', [$quiz, $question]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                            <form action="{{ route('quizzes.questions.destroy', [$quiz, $question]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this question?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="text-gray-900 mb-4">{{ $question->question_text }}</p>
                    
                    <div class="space-y-2">
                        @foreach($question->options as $option)
                        <div class="flex items-center p-3 rounded-lg {{ $option->is_correct ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                            <div class="flex items-center">
                                @if($option->is_correct)
                                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
            </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No questions</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding questions to this quiz.</p>
                <div class="mt-6">
                    <a href="{{ route('quizzes.questions.create', $quiz) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Add Question
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Back to Quiz -->
    <div class="mt-6">
        <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-600 hover:text-blue-800 font-medium">
            ← Back to Quiz
        </a>
    </div>
</div>
@endsection 