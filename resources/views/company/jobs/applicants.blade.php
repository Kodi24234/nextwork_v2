@extends('layouts.company')

@section('title', 'Applicants for Job Posting')
@section('page-title', 'Job Applicants')
@section('content')
    <!-- Header Section -->
    <div class="mb-8">


        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h2>
                <p class="text-gray-600 text-lg">Review candidates who have applied for this position</p>

                <!-- Job Info Pills -->
                <div class="flex flex-wrap items-center gap-3 mt-4">
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-sm font-medium">
                        <i class="ti ti-map-pin text-xs"></i>
                        {{ $job->location }}
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                        {{ ucfirst($job->type) }}
                    </span>
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                        <i class="ti ti-calendar text-xs"></i>
                        Posted {{ $job->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('company.jobs.index') }}"
                    class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <i class="ti ti-arrow-left text-sm mr-2"></i>
                    Back to Jobs
                </a>
                <a href="{{ route('company.jobs.edit', $job) }}"
                    class="inline-flex items-center px-4 py-2 text-teal-700 bg-teal-50 border border-teal-200 rounded-xl hover:bg-teal-100 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <i class="ti ti-edit text-sm mr-2"></i>
                    Edit Job
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Applicants</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $applicants->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">New This Week</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $applicants->where('pivot.created_at', '>=', now()->subWeek())->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-trending-up text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Response Rate</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $applicants->total() > 0 ? '100%' : '0%' }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="ti ti-chart-pie text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Applicants Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filter/Sort Bar -->
        <form method="GET" action="{{ route('company.jobs.applicants', $job) }}">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $applicants->total() }} {{ Str::plural('Applicant', $applicants->total()) }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" name="search" placeholder="Search applicants..."
                                value="{{ request('search') }}"
                                class="pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <i class="ti ti-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                        </div>

                        <!-- Sort -->
                        <select name="sort" onchange="this.form.submit()"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Sort by Date
                            </option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by Name
                            </option>
                        </select>

                        <!-- Clear Filters Button -->

                        <a href="{{ route('company.jobs.applicants', $job) }}"
                            class="inline-flex items-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-sm transition">
                            <i class="ti ti-x text-sm mr-2"></i> Clear Filters
                        </a>

                    </div>
                </div>
            </div>
        </form>
        @if ($applicants->count() > 0)

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Candidate</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Current Role</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Applied Date</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($applicants as $applicant)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <img class="h-8 w-8 rounded-full object-cover ring-2 ring-gray-100"
                                                src="{{ $applicant->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($applicant->name) . '&color=FFFFFF&background=14B8A6' }}"
                                                alt="{{ $applicant->name }}">
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white">
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $applicant->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $applicant->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $applicant->profile->headline ?? 'Professional' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $applicant->profile->location ?? 'Location not specified' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col text-sm">
                                        <span class="font-medium text-gray-900">
                                            {{ $applicant->pivot->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-gray-500 text-xs">
                                            ({{ $applicant->pivot->created_at->diffForHumans() }})
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('company.jobs.applicants.show', ['job' => $job, 'applicant' => $applicant]) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors text-sm font-medium">
                                            <i class="ti ti-eye text-sm mr-2"></i>
                                            View
                                        </a>
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
                    @foreach ($applicants as $applicant)
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="relative flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                                        src="{{ $applicant->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($applicant->name) . '&color=FFFFFF&background=14B8A6' }}"
                                        alt="{{ $applicant->name }}">
                                    <div
                                        class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white">
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-base">{{ $applicant->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $applicant->email }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                            {{ $applicant->pivot->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-3">
                                        {{ $applicant->profile->headline ?? 'Professional' }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">
                                            <i class="ti ti-map-pin text-xs mr-1"></i>
                                            {{ $applicant->profile->location ?? 'Location not specified' }}
                                        </span>

                                        <div class="flex items-center gap-2">
                                            <button
                                                class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <i class="ti ti-mail text-sm"></i>
                                            </button>
                                            <a href="{{ route('company.jobs.applicants.show', ['job' => $job, 'applicant' => $applicant]) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors text-sm font-medium">
                                                <i class="ti ti-eye text-sm mr-2"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti ti-users-off text-blue-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No applicants yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    This job posting hasn't received any applications yet. Great candidates might be reviewing your posting
                    right now!
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('company.jobs.edit', $job) }}"
                        class="inline-flex items-center px-6 py-3 bg-teal-50 text-teal-700 border border-teal-200 rounded-xl hover:bg-teal-100 transition-colors">
                        <i class="ti ti-edit text-lg mr-2"></i>
                        <span>Edit Job Posting</span>
                    </a>

                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if ($applicants->hasPages())
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4">
                {{ $applicants->links() }}
            </div>
        </div>
    @endif



@endsection
