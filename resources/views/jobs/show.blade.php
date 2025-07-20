@extends('layouts.nextwork')

@section('title', 'Find Your Opportunity')

@section('content')

    <div class="max-w-4xl mx-auto">
        <!-- Job Header -->
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-8">
            <div class="flex items-start gap-6">
                <img class="h-20 w-20 rounded-lg object-contain border p-1"
                    src="{{ $job->company->logo_path ? asset('storage/' . $job->company->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($job->company->name) . '&color=FFFFFF&background=14B8A6' }}"
                    alt="{{ $job->company->name }} Logo">
                <div class="flex-grow">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <p class="text-lg text-gray-700 font-medium">{{ $job->company->name }}</p>
                    <div class="mt-2 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">
                        <span class="flex items-center gap-1.5"><i class="ti ti-map-pin"></i> {{ $job->location }}</span>
                        <span class="flex items-center gap-1.5"><i class="ti ti-cash"></i>
                            {{ $job->salary ?? 'Not specified' }}</span>
                        <span class="flex items-center gap-1.5"><i class="ti ti-clock-hour-4"></i>
                            {{ $job->type }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 border-t pt-6 flex items-center justify-between">
                <p class="text-sm text-gray-500">Posted {{ $job->created_at->diffForHumans() }}</p>

                <div>
                    @auth
                        @if (Auth::user()->hasRole('professional'))
                            @if (Auth::user()->jobApplications()->where('job_id', $job->id)->exists())
                                {{-- If user has already applied --}}
                                <button class="bg-green-100 text-green-800 font-bold py-2 px-8 rounded-lg flex items-center"
                                    disabled>
                                    <i class="ti ti-check mr-2"></i> Applied
                                </button>
                            @else
                                {{-- If user has not applied yet --}}
                                <form action="{{ route('jobs.apply', $job) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-teal-600 text-white font-bold py-2 px-8 rounded-lg hover:bg-teal-700 transition-colors">
                                        Apply Now
                                    </button>
                                </form>
                            @endif
                        @endif


                    @endauth
                </div>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'application-submitted')
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-6" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>Your application has been submitted to {{ $job->company->name }}.</p>
                </div>
            @endif
        </div>

        <!-- Job Description -->
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-4">Job Description</h2>
            <div class="prose max-w-none">
                {{-- Use nl2br to respect line breaks from a simple textarea --}}
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>
    </div>

@endsection
