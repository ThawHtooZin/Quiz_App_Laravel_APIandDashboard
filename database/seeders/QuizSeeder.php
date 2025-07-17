<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\Answer;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user (or get existing one)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample quizzes
        $quizzes = [
            [
                'title' => 'General Knowledge Quiz',
                'description' => 'Test your general knowledge with this comprehensive quiz covering various topics.',
                'time_limit' => 15,
                'question_limit' => 5, // Only show 5 questions per attempt
                'is_published' => true,
                'questions' => [
                    [
                        'question_text' => 'What is the capital of France?',
                        'options' => [
                            ['text' => 'London', 'is_correct' => false],
                            ['text' => 'Paris', 'is_correct' => true],
                            ['text' => 'Berlin', 'is_correct' => false],
                            ['text' => 'Madrid', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'Which planet is known as the Red Planet?',
                        'options' => [
                            ['text' => 'Venus', 'is_correct' => false],
                            ['text' => 'Mars', 'is_correct' => true],
                            ['text' => 'Jupiter', 'is_correct' => false],
                            ['text' => 'Saturn', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'What is the largest ocean on Earth?',
                        'options' => [
                            ['text' => 'Atlantic Ocean', 'is_correct' => false],
                            ['text' => 'Indian Ocean', 'is_correct' => false],
                            ['text' => 'Arctic Ocean', 'is_correct' => false],
                            ['text' => 'Pacific Ocean', 'is_correct' => true],
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Programming Basics',
                'description' => 'Test your knowledge of programming fundamentals and concepts.',
                'time_limit' => 20,
                'is_published' => true,
                'questions' => [
                    [
                        'question_text' => 'What does HTML stand for?',
                        'options' => [
                            ['text' => 'Hyper Text Markup Language', 'is_correct' => true],
                            ['text' => 'High Tech Modern Language', 'is_correct' => false],
                            ['text' => 'Home Tool Markup Language', 'is_correct' => false],
                            ['text' => 'Hyperlink and Text Markup Language', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'Which programming language is known as the "language of the web"?',
                        'options' => [
                            ['text' => 'Python', 'is_correct' => false],
                            ['text' => 'Java', 'is_correct' => false],
                            ['text' => 'JavaScript', 'is_correct' => true],
                            ['text' => 'C++', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'What is a variable in programming?',
                        'options' => [
                            ['text' => 'A fixed value that cannot be changed', 'is_correct' => false],
                            ['text' => 'A container that stores data values', 'is_correct' => true],
                            ['text' => 'A type of function', 'is_correct' => false],
                            ['text' => 'A programming language', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'What is the purpose of CSS?',
                        'options' => [
                            ['text' => 'To create web pages', 'is_correct' => false],
                            ['text' => 'To style and layout web pages', 'is_correct' => true],
                            ['text' => 'To add interactivity to web pages', 'is_correct' => false],
                            ['text' => 'To store data', 'is_correct' => false],
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Math Quiz',
                'description' => 'Test your mathematical skills with these challenging questions.',
                'time_limit' => 10,
                'question_limit' => 3, // Only show 3 questions per attempt
                'is_published' => false,
                'questions' => [
                    [
                        'question_text' => 'What is 15 + 27?',
                        'options' => [
                            ['text' => '40', 'is_correct' => false],
                            ['text' => '42', 'is_correct' => true],
                            ['text' => '43', 'is_correct' => false],
                            ['text' => '41', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question_text' => 'What is the square root of 64?',
                        'options' => [
                            ['text' => '6', 'is_correct' => false],
                            ['text' => '7', 'is_correct' => false],
                            ['text' => '8', 'is_correct' => true],
                            ['text' => '9', 'is_correct' => false],
                        ]
                    ]
                ]
            ]
        ];

        foreach ($quizzes as $quizData) {
            $quiz = Quiz::create([
                'title' => $quizData['title'],
                'description' => $quizData['description'],
                'time_limit' => $quizData['time_limit'],
                'question_limit' => $quizData['question_limit'] ?? null,
                'is_published' => $quizData['is_published'],
            ]);

            foreach ($quizData['questions'] as $questionData) {
                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question_text'],
                ]);

                foreach ($questionData['options'] as $optionData) {
                    $question->options()->create([
                        'text' => $optionData['text'],
                        'is_correct' => $optionData['is_correct'],
                    ]);
                }
            }
        }

        // Create some sample quiz results
        $publishedQuizzes = Quiz::where('is_published', true)->get();
        
        foreach ($publishedQuizzes as $quiz) {
            // Create a result for the first quiz
            if ($quiz->title === 'General Knowledge Quiz') {
                $result = QuizResult::create([
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                    'score' => 2, // 2 out of 3 correct
                    'time_taken' => 600, // 10 minutes
                ]);

                // Add answers
                $questions = $quiz->questions;
                $correctAnswers = [1, 1, 3]; // Correct option indices for the questions
                
                foreach ($questions as $index => $question) {
                    $selectedOption = $question->options[$correctAnswers[$index]];
                    Answer::create([
                        'quiz_result_id' => $result->id,
                        'question_id' => $question->id,
                        'selected_option_id' => $selectedOption->id,
                    ]);
                }
            }

            // Create a result for the second quiz
            if ($quiz->title === 'Programming Basics') {
                $result = QuizResult::create([
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                    'score' => 3, // 3 out of 4 correct
                    'time_taken' => 900, // 15 minutes
                ]);

                // Add answers
                $questions = $quiz->questions;
                $correctAnswers = [0, 2, 1, 1]; // Correct option indices for the questions
                
                foreach ($questions as $index => $question) {
                    $selectedOption = $question->options[$correctAnswers[$index]];
                    Answer::create([
                        'quiz_result_id' => $result->id,
                        'question_id' => $question->id,
                        'selected_option_id' => $selectedOption->id,
                    ]);
                }
            }
        }
    }
}
