@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Enhanced Statistics Cards with Animations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-100">Total Quizzes</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_quizzes'] }}</p>
                    <div class="flex items-center mt-1">
                        <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs text-blue-100 ml-1">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-100">Published</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['published_quizzes'] }}</p>
                    <div class="w-full bg-white bg-opacity-20 rounded-full h-2 mt-2">
                        <div class="bg-white h-2 rounded-full" style="width: {{ $stats['total_quizzes'] > 0 ? ($stats['published_quizzes'] / $stats['total_quizzes']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-100">Total Users</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_users'] }}</p>
                    <div class="flex items-center mt-1">
                        <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></div>
                        <span class="text-xs text-purple-100 ml-2">Online</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-100">Total Attempts</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_attempts'] }}</p>
                    <div class="flex items-center mt-1">
                        <svg class="w-4 h-4 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-xs text-yellow-100 ml-1">Growing</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-100">Avg Score</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['average_score'] }}%</p>
                    <div class="flex items-center mt-1">
                        <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full transition-all duration-1000" style="width: {{ $stats['average_score'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-indigo-100">Total Questions</p>
                    <p class="text-3xl font-bold text-white">{{ $additionalStats['total_questions'] ?? 0 }}</p>
                    <div class="flex items-center mt-1">
                        <svg class="w-4 h-4 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs text-indigo-100 ml-1">Available</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quiz Performance Chart -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quiz Performance Overview</h3>
                <p class="text-sm text-gray-600">Average scores by quiz</p>
            </div>
            <div class="p-6">
                <canvas id="quizPerformanceChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- User Activity Chart -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Activity Trend</h3>
                <p class="text-sm text-gray-600">Quiz attempts over time</p>
            </div>
            <div class="p-6">
                <canvas id="userActivityChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Activity and Top Quizzes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Quiz Results with Visual Indicators -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Quiz Results</h3>
                <p class="text-sm text-gray-600">Latest performance data</p>
            </div>
            <div class="p-6">
                @if($recentResults->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentResults as $result)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($result->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $result->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $result->quiz->title }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-1000" 
                                             style="width: {{ $result->percentage }}%"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $result->score }}/{{ $result->quiz->questions_count }}</p>
                                        <p class="text-sm {{ $result->percentage >= 80 ? 'text-green-600' : ($result->percentage >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $result->percentage }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-gray-500 mt-2">No recent quiz results</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Quizzes with Visual Rankings -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Most Popular Quizzes</h3>
                <p class="text-sm text-gray-600">By number of attempts</p>
            </div>
            <div class="p-6">
                @if($topQuizzes->count() > 0)
                    <div class="space-y-4">
                        @foreach($topQuizzes as $index => $quiz)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm
                                    {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : 
                                       ($index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-600' : 
                                        ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-blue-400 to-blue-600')) }}">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $quiz->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $quiz->questions_count }} questions</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full transition-all duration-1000" 
                                             style="width: {{ $topQuizzes->max('quiz_results_count') > 0 ? ($quiz->quiz_results_count / $topQuizzes->max('quiz_results_count')) * 100 : 0 }}%"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $quiz->quiz_results_count }}</p>
                                        <p class="text-sm text-gray-600">attempts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 mt-2">No quizzes available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Quizzes Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Recent Quizzes</h3>
                    <p class="text-sm text-gray-600">Latest quiz activities</p>
                </div>
                <a href="{{ route('quizzes.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    View all
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recentQuizzes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentQuizzes as $quiz)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $quiz->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($quiz->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-900">{{ $quiz->questions_count }}</span>
                                        <div class="ml-2 w-12 bg-gray-200 rounded-full h-1">
                                            <div class="bg-blue-600 h-1 rounded-full" style="width: {{ $quiz->questions_count > 0 ? min(($quiz->questions_count / 10) * 100, 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $quiz->quiz_results_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-900">{{ $quiz->quiz_results_avg_score ?? 0 }}%</span>
                                        <div class="ml-2 w-12 bg-gray-200 rounded-full h-1">
                                            <div class="bg-green-600 h-1 rounded-full transition-all duration-1000" style="width: {{ $quiz->quiz_results_avg_score ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($quiz->is_published)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-1"></div>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 mt-2">No quizzes created yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quiz Performance Chart
    const quizPerformanceCtx = document.getElementById('quizPerformanceChart').getContext('2d');
    new Chart(quizPerformanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($quizPerformance->pluck('title')) !!},
            datasets: [{
                label: 'Average Score (%)',
                data: {!! json_encode($quizPerformance->pluck('avg_score')) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(139, 92, 246, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // User Activity Chart with real data
    const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
    new Chart(userActivityCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($userActivity->pluck('date')) !!},
            datasets: [{
                label: 'Quiz Attempts',
                data: {!! json_encode($userActivity->pluck('attempts')) !!},
                borderColor: 'rgba(139, 92, 246, 1)',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Add some interactive animations
    const cards = document.querySelectorAll('.transform');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
        });
    });
});
</script>
@endsection 