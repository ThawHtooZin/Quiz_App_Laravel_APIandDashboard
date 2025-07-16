@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Key Performance Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Quiz Engagement Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Quiz Engagement</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['total_attempts'] }}</p>
                    <p class="text-blue-200 text-xs mt-1">Total attempts</p>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <span class="text-green-300 text-sm font-medium">+12%</span>
                        <span class="text-blue-200 text-xs">vs last week</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Performance Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Avg Performance</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['average_score'] }}%</p>
                    <p class="text-green-200 text-xs mt-1">Across all quizzes</p>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full transition-all duration-1000" style="width: {{ $stats['average_score'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Active Users</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $additionalStats['active_users_today'] ?? 0 }}</p>
                    <p class="text-purple-200 text-xs mt-1">Today's activity</p>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse mx-auto"></div>
                        <span class="text-purple-200 text-xs">Online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Completion Rate -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Completion Rate</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['total_quizzes'] > 0 ? round(($stats['published_quizzes'] / $stats['total_quizzes']) * 100) : 0 }}%</p>
                    <p class="text-orange-200 text-xs mt-1">{{ $stats['published_quizzes'] }}/{{ $stats['total_quizzes'] }} published</p>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <span class="text-orange-300 text-sm font-medium">{{ $stats['published_quizzes'] }}</span>
                        <span class="text-orange-200 text-xs">Live</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Analytics Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Quiz Performance Overview -->
        <div class="xl:col-span-2 bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Quiz Performance Overview</h3>
                        <p class="text-sm text-gray-600">Average scores and engagement metrics</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">This Week</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">This Month</button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <canvas id="quizPerformanceChart" height="300"></canvas>
            </div>
        </div>

        <!-- Quick Actions & Insights -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                <p class="text-sm text-gray-600">Manage your quiz system</p>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('quizzes.create') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-600 transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Create New Quiz</p>
                        <p class="text-sm text-gray-600">Add a new quiz to your collection</p>
                    </div>
                </a>

                <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-all duration-200 group">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Manage Users</p>
                        <p class="text-sm text-gray-600">View and manage user accounts</p>
                    </div>
                </a>

                <a href="{{ route('users.results') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">View Results</p>
                        <p class="text-sm text-gray-600">Analyze quiz performance</p>
                    </div>
                </a>

                <div class="pt-4 border-t border-gray-100">
                    <h4 class="font-medium text-gray-900 mb-3">System Insights</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700">System Status</span>
                            </div>
                            <span class="text-sm font-medium text-green-600">Healthy</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700">Database</span>
                            </div>
                            <span class="text-sm font-medium text-blue-600">Connected</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700">Last Backup</span>
                            </div>
                            <span class="text-sm font-medium text-yellow-600">2 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Activity & Recent Results -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- User Activity Trend -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">User Activity Trend</h3>
                <p class="text-sm text-gray-600">Quiz attempts over the last 7 days</p>
            </div>
            <div class="p-6">
                <canvas id="userActivityChart" height="250"></canvas>
            </div>
        </div>

        <!-- Recent Quiz Results -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Quiz Results</h3>
                        <p class="text-sm text-gray-600">Latest performance data</p>
                    </div>
                    <a href="{{ route('users.results') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentResults->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentResults->take(5) as $result)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($result->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $result->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ Str::limit($result->quiz->title, 25) }}</p>
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
    </div>

    <!-- Top Performing Quizzes -->
    <div class="bg-white rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Top Performing Quizzes</h3>
                    <p class="text-sm text-gray-600">Most popular and highest scoring quizzes</p>
                </div>
                <a href="{{ route('quizzes.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    View all quizzes
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($topQuizzes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($topQuizzes->take(6) as $index => $quiz)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm
                                    {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : 
                                       ($index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-600' : 
                                        ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-blue-400 to-blue-600')) }}">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ Str::limit($quiz->title, 20) }}</h4>
                                    <p class="text-sm text-gray-600">{{ $quiz->questions_count }} questions</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Attempts</span>
                                <span class="font-semibold text-gray-900">{{ $quiz->quiz_results_count }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Avg Score</span>
                                <span class="font-semibold text-gray-900">{{ round($quiz->quiz_results_avg_score ?? 0, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full transition-all duration-1000" 
                                     style="width: {{ $topQuizzes->max('quiz_results_count') > 0 ? ($quiz->quiz_results_count / $topQuizzes->max('quiz_results_count')) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $quiz->created_at->diffForHumans() }}</span>
                                <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Details</a>
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
});
</script>
@endsection 