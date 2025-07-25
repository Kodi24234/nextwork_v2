@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
            <p class="text-gray-600">Monitor your platform's performance and activity</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-200 shadow-sm">
                <i class="ti ti-calendar text-gray-400"></i>
                <span class="text-sm font-medium text-gray-700">{{ now()->format('F d, Y') }}</span>
            </div>

        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
            $cards = [
                [
                    'label' => 'Total Professionals',
                    'count' => $professionalCount,
                    'icon' => 'ti ti-users',
                    'bg' => 'from-teal-500 to-teal-600',
                ],
                [
                    'label' => 'Total Companies',
                    'count' => $companyCount,
                    'icon' => 'ti ti-building-skyscraper',
                    'bg' => 'from-blue-500 to-blue-600',
                ],
                [
                    'label' => 'Open Jobs',
                    'count' => $openJobCount,
                    'icon' => 'ti ti-briefcase',
                    'bg' => 'from-green-500 to-green-600',
                ],
                [
                    'label' => 'Closed Jobs',
                    'count' => $closedJobCount,
                    'icon' => 'ti ti-lock',
                    'bg' => 'from-red-500 to-red-600',
                ],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-600">{{ $card['label'] }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($card['count']) }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br {{ $card['bg'] }} rounded-xl flex items-center justify-center shadow-lg">
                        <i class="{{ $card['icon'] }} text-white text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <!-- Recent Job Postings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Job Postings</h3>
                <a href="{{ route('admin.jobs.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                    View all
                </a>
            </div>
            <div class="space-y-3">
                @forelse ($recentJobs ?? [] as $job)
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                        <div class="w-9 h-9 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-briefcase text-teal-600 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $job->title }}</p>
                            <p class="text-sm text-gray-600">{{ $job->company->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $job->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 text-sm">No recent job postings</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Companies -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Companies</h3>
                <a href="{{ route('admin.companies.index') }}"
                    class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                    View all
                </a>
            </div>
            <div class="space-y-3">
                @forelse ($recentCompanies ?? [] as $company)
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-building text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $company->name }}</p>
                            <p class="text-sm text-gray-600">{{ $company->user->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $company->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 text-sm">No recent companies</div>
                @endforelse
            </div>
        </div>

        <!-- Newest Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Newest Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                    View all
                </a>
            </div>
            <div class="space-y-3">
                @forelse ($recentUsers ?? [] as $user)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=FFFFFF&background=14B8A6&size=40"
                                alt="{{ $user->name }}" class="w-9 h-9 rounded-full ring-2 ring-gray-100">
                            <div
                                class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $user->email }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 text-sm">No new users recently</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- User Registration Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">User Registrations</h3>
                <p class="text-sm text-gray-600">New user signups over the last 14 days</p>
            </div>
            <div class="h-64 relative">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>

        <!-- Job Posting Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Job Postings</h3>
                <p class="text-sm text-gray-600">New job listings over the last 14 days</p>
            </div>
            <div class="h-64 relative">
                <canvas id="jobPostingChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="flex flex-col gap-3">
            <button
                class="w-12 h-12 bg-teal-600 text-white rounded-full shadow-lg hover:bg-teal-700 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 flex items-center justify-center"
                title="Add New User">
                <i class="ti ti-user-plus text-lg"></i>
            </button>
            <button
                class="w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 flex items-center justify-center"
                title="System Settings">
                <i class="ti ti-settings text-lg"></i>
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart configuration
            Chart.defaults.font.family = 'Inter, sans-serif';
            Chart.defaults.color = '#6B7280';

            // User Registration Chart
            const userCtx = document.getElementById('userRegistrationChart');
            new Chart(userCtx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels ?? []),
                    datasets: [{
                        label: 'New Users',
                        data: @json($chartData ?? []),
                        borderColor: '#14B8A6',
                        backgroundColor: 'rgba(20, 184, 166, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#14B8A6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#14B8A6',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            // Job Posting Chart
            const jobCtx = document.getElementById('jobPostingChart');
            new Chart(jobCtx, {
                type: 'line',
                data: {
                    labels: @json($jobChartLabels ?? []),
                    datasets: [{
                        label: 'New Jobs',
                        data: @json($jobChartData ?? []),
                        borderColor: '#F97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#F97316',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#F97316',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
    </script>
@endpush
