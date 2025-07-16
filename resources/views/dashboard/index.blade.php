@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Simple Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
                <p class="text-blue-100 text-lg">Quiz System Overview</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold">{{ $stats['total_attempts'] }}</div>
                <div class="text-blue-100">Total Attempts</div>
            </div>
        </div>
    </div>

    <!-- Main Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quiz Performance Chart -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Quiz Performance</h3>
                <p class="text-sm text-gray-600">Average scores by quiz</p>
            </div>
            <div class="p-6">
                <canvas id="quizPerformanceChart" height="300"></canvas>
            </div>
        </div>

        <!-- User Activity Chart -->
        <div class="bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">User Activity</h3>
                <p class="text-sm text-gray-600">Quiz attempts over time</p>
            </div>
            <div class="p-6">
                <canvas id="userActivityChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Stats & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Total Quizzes</span>
                    <span class="font-semibold text-gray-900">{{ $stats['total_quizzes'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Published</span>
                    <span class="font-semibold text-gray-900">{{ $stats['published_quizzes'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Total Users</span>
                    <span class="font-semibold text-gray-900">{{ $stats['total_users'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Avg Score</span>
                    <span class="font-semibold text-gray-900">{{ $stats['average_score'] }}%</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('quizzes.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors">
                    Create Quiz
                </a>
                <a href="{{ route('quizzes.index') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors">
                    View Quizzes
                </a>
                <a href="{{ route('users.index') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors">
                    Manage Users
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
            @if($recentResults->count() > 0)
                <div class="space-y-3">
                    @foreach($recentResults->take(3) as $result)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $result->user->name }}</p>
                            <p class="text-gray-600 text-xs">{{ Str::limit($result->quiz->title, 20) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 text-sm">{{ $result->percentage }}%</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No recent activity</p>
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
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 8,
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
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });

    // User Activity Chart
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
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
});
</script>
@endsection 