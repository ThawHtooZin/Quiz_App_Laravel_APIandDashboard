@extends('layouts.app')

@section('title', 'Add Question - ' . $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add Question to: {{ $quiz->title }}</h1>
        <p class="text-gray-600">Create a new question with multiple choice options.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <form action="{{ route('quizzes.questions.store', $quiz) }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="question_text" class="block text-sm font-medium text-gray-700">Question</label>
                <textarea name="question_text" id="question_text" rows="3" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('question_text') }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Options</label>
                <div id="options-container" class="space-y-3">
                    <div class="option-row flex items-center space-x-3">
                        <input type="radio" name="correct_option" value="0" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                        <input type="text" name="options[0][text]" placeholder="Option 1" required
                            class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="remove-option text-red-600 hover:text-red-800" style="display: none;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="option-row flex items-center space-x-3">
                        <input type="radio" name="correct_option" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                        <input type="text" name="options[1][text]" placeholder="Option 2" required
                            class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="remove-option text-red-600 hover:text-red-800" style="display: none;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="button" id="add-option" class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                    + Add another option
                </button>
                
                @error('options')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('correct_option')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('quizzes.questions.index', $quiz) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                    Add Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const optionsContainer = document.getElementById('options-container');
    const addOptionBtn = document.getElementById('add-option');
    let optionCount = 2;

    addOptionBtn.addEventListener('click', function() {
        const optionRow = document.createElement('div');
        optionRow.className = 'option-row flex items-center space-x-3';
        optionRow.innerHTML = `
            <input type="radio" name="correct_option" value="${optionCount}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
            <input type="text" name="options[${optionCount}][text]" placeholder="Option ${optionCount + 1}" required
                class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <button type="button" class="remove-option text-red-600 hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        optionsContainer.appendChild(optionRow);
        optionCount++;

        // Show remove buttons if more than 2 options
        if (optionCount > 2) {
            document.querySelectorAll('.remove-option').forEach(btn => btn.style.display = 'block');
        }
    });

    // Handle remove option
    optionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-option')) {
            const optionRow = e.target.closest('.option-row');
            optionRow.remove();
            optionCount--;

            // Hide remove buttons if only 2 options left
            if (optionCount <= 2) {
                document.querySelectorAll('.remove-option').forEach(btn => btn.style.display = 'none');
            }

            // Update option indices
            document.querySelectorAll('.option-row').forEach((row, index) => {
                const radio = row.querySelector('input[type="radio"]');
                const input = row.querySelector('input[type="text"]');
                radio.value = index;
                input.name = `options[${index}][text]`;
                input.placeholder = `Option ${index + 1}`;
            });
        }
    });
});
</script>
@endsection 