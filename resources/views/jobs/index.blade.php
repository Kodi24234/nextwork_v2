@extends('layouts.nextwork')

@section('title', 'Find Your Opportunity')

@section('content')

    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Job Listings</h1>
            <p class="mt-2 text-lg text-gray-600">Browse opportunities from top companies in our network.</p>
        </div>

        <!-- Job Listings -->
        <div class="space-y-6">
            @forelse ($jobs as $job)
                <a href="{{ route('jobs.show', $job) }}"
                    class="block bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:border-teal-500 hover:shadow-lg transition-all duration-300">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            <img class="h-16 w-16 rounded-lg object-contain border p-1"
                                src="{{ $job->company->logo_path ? asset('storage/' . $job->company->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($job->company->name) . '&color=FFFFFF&background=14B8A6' }}"
                                alt="{{ $job->company->name }} Logo">
                        </div>

                        <!-- Job Info -->
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-gray-900">{{ $job->title }}</h3>
                            <p class="text-md text-gray-700 font-medium">{{ $job->company->name }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5"><i class="ti ti-map-pin"></i>
                                    {{ $job->location }}</span>
                                <span class="flex items-center gap-1.5"><i class="ti ti-cash"></i>
                                    {{ $job->salary ?? 'Not specified' }}</span>
                                <span class="flex items-center gap-1.5"><i class="ti ti-clock-hour-4"></i>
                                    {{ $job->type }}</span>
                            </div>
                        </div>

                        <!-- Date Posted -->
                        <div class="flex-shrink-0 text-sm text-gray-500 text-left sm:text-right">
                            <p>{{ $job->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-gray-500 py-16 bg-white rounded-xl shadow-md">
                    <i class="ti ti-briefcase-off text-6xl text-gray-300"></i>
                    <h3 class="mt-4 text-xl font-semibold">No Job Openings Found</h3>
                    <p>Please check back later for new opportunities.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>

@endsection
