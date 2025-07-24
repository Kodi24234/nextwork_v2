@extends('layouts.nextwork')

@section('title', $job->title . ' at ' . $job->company->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Back Link -->
        <div class="mb-4">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-sm text-teal-600 hover:underline">
                <i class="ti ti-arrow-left mr-1"></i> Back to Job Listings
            </a>
        </div>

        <!-- Job Header Card -->
        <div class="bg-white rounded-xl shadow p-6 md:p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:gap-6">
                <!-- Logo -->
                <img class="h-20 w-20 rounded-lg object-contain border p-1 mb-4 sm:mb-0"
                    src="{{ $job->company->logo_path ? asset('storage/' . $job->company->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($job->company->name) . '&color=FFFFFF&background=14B8A6' }}"
                    alt="{{ $job->company->name }} Logo">

                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">{{ $job->title }}</h1>
                    <p class="text-lg text-gray-700 font-medium">{{ $job->company->name }}</p>
                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
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
                </div>
            </div>

            <!-- Apply Section -->
            <div class="mt-6 pt-6 border-t flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="text-sm text-gray-500">
                    Posted {{ $job->created_at->diffForHumans() }}
                    <span class="hidden sm:inline">({{ $job->created_at->format('F j, Y') }})</span>
                </p>

                @auth
                    @if (Auth::user()->hasRole('professional'))
                        @php
                            $alreadyApplied = Auth::user()->jobApplications()->where('job_id', $job->id)->exists();
                        @endphp

                        @if ($alreadyApplied)
                            <span
                                class="inline-flex items-center bg-green-100 text-green-800 font-semibold text-sm px-4 py-2 rounded-lg">
                                <i class="ti ti-check mr-2"></i> Already Applied
                            </span>
                        @else
                            <form action="{{ route('jobs.apply', $job) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-teal-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-teal-700 transition">
                                    Apply Now
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth
            </div>

            <!-- Success Message -->
            @if (session('status') === 'application-submitted')
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mt-6 relative flex items-start gap-3 rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-800 shadow-sm"
                    role="alert">
                    <div class="flex-shrink-0 pt-0.5">
                        <i class="ti ti-circle-check text-lg text-green-600"></i>
                    </div>

                    <div class="flex-1">
                        <p class="font-semibold mb-1">Application Submitted</p>
                        <p>Your application has been successfully sent to <strong>{{ $job->company->name }}</strong>.</p>
                    </div>

                    <button @click="show = false"
                        class="absolute top-2 right-2 text-green-600 hover:text-green-800 focus:outline-none"
                        aria-label="Dismiss">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
            @endif

        </div>

        <!-- Job Description Card -->
        <div class="bg-white rounded-xl shadow p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-4">Job Description</h2>
            <div class="prose max-w-none text-gray-800">
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>


    </div>
@endsection
