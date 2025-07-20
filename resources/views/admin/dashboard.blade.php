@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <h1 class="text-2xl lg:text-3xl font-bold text-teal-700 mb-2 sm:mb-0">Dashboard Overview</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <i class="ti ti-calendar-event"></i>
            <span>{{ now()->format('F d, Y') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Professionals</p>
                <p class="text-3xl font-bold">{{ $professionalCount }}</p>
            </div>
            <div class="bg-teal-100 p-3 rounded-full">
                <i class="ti ti-users text-teal-600 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Companies</p>
                <p class="text-3xl font-bold">{{ $companyCount }}</p>
            </div>
            <div class="bg-sky-100 p-3 rounded-full">
                <i class="ti ti-building-skyscraper text-sky-600 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Open Jobs</p>
                <p class="text-3xl font-bold">{{ $openJobCount }}</p>
            </div>
            <div class="bg-emerald-100 p-3 rounded-full">
                <i class="ti ti-briefcase text-emerald-600 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Closed Jobs</p>
                <p class="text-3xl font-bold">{{ $closedJobCount }}</p>
            </div>
            <div class="bg-rose-100 p-3 rounded-full">
                <i class="ti ti-lock text-rose-500 text-2xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- LEFT COLUMN -->
        <div class="space-y-8">
            <!-- User Chart -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">User Registrations (Last 14 Days)</h2>
                <div class="h-64">
                    <canvas id="userRegistrationChart"></canvas>
                </div>
            </div>

            <!-- Job Chart -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Postings (Last 14 Days)</h2>
                <div class="h-64">
                    <canvas id="jobPostingChart"></canvas>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="space-y-4">
            <!-- Recent Jobs -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Job Postings</h3>
                <div class="space-y-4">
                    @forelse ($recentJobs ?? [] as $job)
                        <div>
                            <p class="font-semibold text-gray-700">{{ $job->title }}</p>
                            <p class="text-sm text-gray-500">{{ $job->company->name }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No recent jobs found.</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.jobs.index') }}"
                    class="text-teal-600 hover:underline text-sm font-medium mt-4 block">View all jobs →</a>
            </div>

            <!-- Recent Companies -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Companies</h3>
                <div class="space-y-4">
                    @forelse ($recentCompanies ?? [] as $company)
                        <div>
                            <p class="font-semibold text-gray-700">{{ $company->name }}</p>
                            <p class="text-sm text-gray-500">{{ $company->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No recent companies found.</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="text-teal-600 hover:underline text-sm font-medium mt-4 block">View all companies
                    →</a>
            </div>

            <!-- New Users -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Newest Users</h3>
                <div class="space-y-4">
                    @forelse ($recentUsers ?? [] as $user)
                        <div class="flex items-center space-x-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold text-gray-700">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No new users recently.</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="text-teal-600 hover:underline text-sm font-medium mt-4 block">View all users →</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Registration Chart
            new Chart(document.getElementById('userRegistrationChart'), {
                type: 'line',
                data: {
                    labels: @json($chartLabels ?? []),
                    datasets: [{
                        label: 'New Users',
                        data: @json($chartData ?? []),
                        borderColor: 'rgb(13, 148, 136)',
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
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
                            beginAtZero: true
                        }
                    }
                }
            });

            // Job Posting Chart
            new Chart(document.getElementById('jobPostingChart'), {
                type: 'line',
                data: {
                    labels: @json($jobChartLabels ?? []),
                    datasets: [{
                        label: 'New Jobs',
                        data: @json($jobChartData ?? []),
                        borderColor: 'rgb(234, 88, 12)',
                        backgroundColor: 'rgba(234, 88, 12, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
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
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
