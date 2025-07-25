@extends('layouts.company')
@section('title', 'Manage Jobs')
@section('page-title', 'Manage Jobs')
@section('content')
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Your Job Listings</h2>
            <p class="text-gray-600 mt-1">Manage and track all your job postings</p>
        </div>
        <a href="{{ route('company.jobs.create') }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <i class="ti ti-plus text-lg mr-2"></i>
            <span>Post New Job</span>
        </a>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms
            class="flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mb-6 shadow-sm"
            role="alert">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-green-600 text-lg"></i>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-green-800">Success!</p>
                    <p class="text-green-700 text-sm">{{ session('status') }}</p>
                </div>
            </div>
            <button @click="show = false"
                class="flex-shrink-0 p-1 text-green-600 hover:text-green-800 hover:bg-green-100 rounded-lg transition-colors">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>
    @endif

    <!-- Stats Cards (Optional - add if you have the data) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $jobs->total() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-briefcase text-teal-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Open Positions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $jobs->where('status', 'open')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-circle-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $jobs->sum('applicants_count') ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">This Month</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $jobs->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-calendar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Table/Cards -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if ($jobs->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Job
                                Details</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Location & Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Applications</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($jobs as $job)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $job->title }}</h3>
                                        <p class="text-gray-500 text-xs mt-1">Posted {{ $job->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <i class="ti ti-map-pin text-xs"></i>
                                            {{ $job->location }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 w-fit">
                                            {{ ucfirst($job->type) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('company.jobs.applicants', $job) }}"
                                        class="inline-flex items-center gap-2 px-3 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors text-sm font-medium">
                                        <i class="ti ti-users text-sm"></i>
                                        <span>{{ $job->applicants_count }}
                                            {{ Str::plural('Application', $job->applicants_count) }}</span>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($job->status == 'open')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                            <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                                            Open
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                                            Closed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('company.jobs.edit', $job) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition-colors"
                                            title="Edit Job">
                                            <i class="ti ti-edit text-sm"></i>
                                        </a>
                                        <div x-data="{ open: false }">
                                            <button @click="open = true"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete Job">
                                                <i class="ti ti-trash text-sm"></i>
                                            </button>
                                            @include('company.jobs.partials.delete-modal', ['job' => $job])
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden">
                <div class="divide-y divide-gray-200">
                    @foreach ($jobs as $job)
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-base">{{ $job->title }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">Posted {{ $job->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 ml-4">
                                    <a href="{{ route('company.jobs.edit', $job) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition-colors">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <div x-data="{ open: false }">
                                        <button @click="open = true"
                                            class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        @include('company.jobs.partials.delete-modal', ['job' => $job])
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-map-pin text-gray-400 text-sm"></i>
                                    <span class="text-gray-600 text-sm">{{ $job->location }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ ucfirst($job->type) }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('company.jobs.applicants', $job) }}"
                                        class="inline-flex items-center gap-2 px-3 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors text-sm font-medium">
                                        <i class="ti ti-users text-sm"></i>
                                        <span>{{ $job->applicants_count }} Applications</span>
                                    </a>

                                    @if ($job->status == 'open')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                            <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                                            Open
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                                            Closed
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti ti-briefcase-off text-teal-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No job listings yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Start building your team by posting your first job listing.
                    Great talent is waiting to discover your opportunity!</p>
                <a href="{{ route('company.jobs.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="ti ti-plus text-lg mr-2"></i>
                    <span>Post Your First Job</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if ($jobs->hasPages())
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4">
                {{ $jobs->links() }}
            </div>
        </div>
    @endif
@endsection
