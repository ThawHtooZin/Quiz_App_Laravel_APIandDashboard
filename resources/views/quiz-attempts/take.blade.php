@extends('layouts.app')

@section('title', 'Taking Quiz - ' . $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Quiz Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                <p class="text-gray-600">{{ $questions->count() }} questions</p>
            </div>
            @if($quiz->time_limit)
            <div class="text-right">
                <div class="text-sm text-gray-600">Time Remaining</div>
                <div id="timer" class="text-2xl font-bold text-red-600">{{ $quiz->time_limit }}:00</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quiz Form -->
    <form action="{{ route('quiz-attempts.submit', $quiz) }}" method="POST" id="quiz-form">
        @csrf
        <input type="hidden" name="time_taken" id="time_taken" value="0">
        
        <div class="space-y-6">
            @foreach($questions as $index => $question)
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Question {{ $index + 1 }} of {{ $questions->count() }}
                    </h3>
                    
                    <p class="text-gray-900 mb-6">{{ $question->question_text }}</p>
                    
                    <div class="space-y-3">
                        @foreach($question->options as $option)
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-3 text-gray-900">{{ $option->text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="mt-8 text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium text-lg">
                Submit Quiz
            </button>
        </div>
    </form>
</div>

@if($quiz->time_limit)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('timer');
    const timeTakenInput = document.getElementById('time_taken');
    const quizForm = document.getElementById('quiz-form');
    
    let timeLimit = {{ $quiz->time_limit * 60 }}; // Convert to seconds
    let timeElapsed = 0;
    
    const timer = setInterval(function() {
        timeElapsed++;
        const remaining = timeLimit - timeElapsed;
        
        if (remaining <= 0) {
            clearInterval(timer);
            timeTakenInput.value = timeElapsed;
            quizForm.submit();
            return;
        }
        
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        // Change color when time is running low
        if (remaining <= 300) { // 5 minutes
            timerElement.classList.add('text-red-600');
        }
    }, 1000);
    
    // Update time taken when form is submitted
    quizForm.addEventListener('submit', function() {
        timeTakenInput.value = timeElapsed;
    });
});
</script>
@endif
@endsection 