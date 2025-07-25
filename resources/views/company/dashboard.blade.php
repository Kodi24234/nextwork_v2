@extends('layouts.company')

@section('title', 'Company Dashboard')

@section('content')

    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Welcome, {{ $company->name }}!
            </h2>
            <p class="text-gray-600 mt-1">
                Manage your company profile, post jobs, and find your next great hire.
            </p>
        </div>

        <!-- Main Action Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Action Card 1: Post a New Job -->
            <a href="{{ route('company.jobs.create') }}"
                class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-teal-100 p-4 rounded-full">
                        <i class="ti ti-file-plus text-2xl text-teal-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Post a New Job</h4>
                        <p class="text-gray-600">Create a new job listing to attract talent.</p>
                    </div>
                </div>
            </a>

            <!-- Action Card 2: Manage Job Listings -->
            <a href="{{ route('company.jobs.index') }}"
                class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-sky-100 p-4 rounded-full">
                        <i class="ti ti-briefcase text-2xl text-sky-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Manage Jobs</h4>
                        <p class="text-gray-600">View and edit your active job postings.</p>
                    </div>
                </div>
            </a>

            <!-- Action Card 3: Edit Company Profile -->
            <a href="{{ route('company.profile.edit') }}"
                class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="ti ti-building-skyscraper text-2xl text-purple-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Edit Company Profile</h4>
                        <p class="text-gray-600">Update your company's logo and details.</p>
                    </div>
                </div>
            </a>

        </div>

        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Applicants</h3>

            <ul class="divide-y divide-gray-200">
                @foreach ($recentApplicants as $applicant)
                    <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $applicant->user_name }}</p>
                            <p class="text-sm text-gray-500">
                                Applied for: <strong>{{ $applicant->job_title }}</strong>
                            </p>
                            <p class="text-xs text-gray-400">
                                Submitted {{ \Carbon\Carbon::parse($applicant->created_at)->diffForHumans() }}
                            </p>
                        </div>

                        <a href="{{ route('company.jobs.applicants.show', ['job' => $applicant->job_id, 'applicant' => $applicant->user_id]) }}"
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-700 border border-teal-200 rounded-lg hover:bg-teal-100 transition-colors text-sm font-medium">
                            <i class="ti ti-eye text-sm mr-2"></i>
                            View Profile
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>




    </div>
@endsection
