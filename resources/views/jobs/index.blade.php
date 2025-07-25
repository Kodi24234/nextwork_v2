@extends('layouts.nextwork')

@section('title', 'Find Your Opportunity')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center  mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 ">Job Listings</h1>
            <p class="mt-2 text-base sm:text-lg text-gray-600">Explore roles from top companies in the NextWork network.</p>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('jobs.index') }}" class="bg-white rounded-xl shadow p-6 mb-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Keyword Search -->
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Search by job title or company"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm px-4 py-2">

                <!-- Location -->
                <input type="text" name="location" value="{{ request('location') }}"
                    placeholder="Location (e.g., Yangon, Remote)"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm px-4 py-2">

                <!-- Job Type -->
                <select name="type"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm px-4 py-2">
                    <option value="">All Types</option>
                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                    <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="remote" {{ request('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                </select>

                <!-- Filter + Clear -->
                <div class="flex gap-3 items-center">
                    <button type="submit"
                        class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-700 transition text-sm">
                        Filter
                    </button>

                    <a href="{{ route('jobs.index') }}"
                        class="text-sm text-gray-500 hover:text-purple-600 whitespace-nowrap">
                        Clear
                    </a>
                </div>
            </div>
        </form>



        <!-- Job Listings -->
        <div class="space-y-8">
            @forelse ($jobs as $job)
                <a href="{{ route('jobs.show', $job) }}"
                    class="block bg-white rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 group relative">
                    <div
                        class="absolute left-0 top-0 h-full w-1 bg-purple-500 rounded-l-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                    </div>

                    <div class="p-6 sm:flex sm:gap-6">
                        <!-- Company Logo -->
                        <div class="flex justify-center sm:justify-start sm:w-24 mb-4 sm:mb-0">
                            <img class="h-16 w-16 object-contain rounded-lg border p-1"
                                src="{{ $job->company->logo_path
                                    ? asset('storage/' . $job->company->logo_path)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($job->company->name) . '&color=FFFFFF&background=14B8A6' }}"
                                alt="{{ $job->company->name }} Logo">
                        </div>

                        <!-- Job Info -->
                        <div class="flex-grow">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition">
                                    {{ $job->title }}
                                </h3>
                                <span
                                    class="mt-2 sm:mt-0 inline-flex items-center gap-1.5 bg-purple-100 text-purple-800 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <i class="ti ti-briefcase"></i> {{ ucfirst($job->type) }}
                                </span>
                            </div>

                            <p class="text-md text-gray-700 font-medium mt-1">{{ $job->company->name }}</p>

                            <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <i class="ti ti-map-pin"></i> {{ $job->location }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <i class="ti ti-cash"></i> {{ $job->salary ?? 'Not specified' }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <i class="ti ti-clock-hour-4"></i> {{ $job->type }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-400 mt-3">Posted {{ $job->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-gray-500 py-16 bg-white rounded-xl shadow-md">
                    <i class="ti ti-briefcase-off text-6xl text-gray-300"></i>
                    <h3 class="mt-4 text-xl font-semibold">No Job Openings Found</h3>
                    <p class="text-sm">Please check back later for new opportunities.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($jobs->hasPages())
            <div class="mt-10 mb-6 overflow-x-auto pb-20 sm:pb-0">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
@endsection
