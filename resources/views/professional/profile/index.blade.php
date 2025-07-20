@extends('layouts.nextwork')

@section('title', 'Edit Profile')

@section('content')
    <div x-data="{ tab: 'personal' }" class="max-w-5xl mx-auto bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Your Profile</h2>
            <a href="{{ route('profile.edit') }}"
                class="bg-teal-600 text-white px-4 py-2 text-sm rounded-md hover:bg-teal-700">
                <i class="fa-solid fa-user-pen"></i>
                Edit Profile
            </a>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-6 text-sm font-medium text-gray-600">
                <button @click="tab = 'personal'" :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'personal' }"
                    class="pb-2">Personal
                    Info</button>
                <button @click="tab = 'experience'"
                    :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'experience' }" class="pb-2">Work
                    Experience</button>
                <button @click="tab = 'education'"
                    :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'education' }"
                    class="pb-2">Education</button>
                <button @click="tab = 'skills'" :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'skills' }"
                    class="pb-2">Skills</button>
            </nav>
        </div>

        <!-- Tab 1: Personal Info -->
        <div x-show="tab === 'personal'" class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <div class="">
                <div class="flex justify-between items-center mb-6">
                    {{--     --}}
                    {{-- <a href="{{ route('profile.edit') }}" class="bg-teal-600 text-white px-4 py-2 text-sm rounded-md hover:bg-teal-700">
                        <i class="fa-solid fa-user-pen"></i>
                        Edit Profile
                    </a> --}}
                </div>

                <div
                    class="flex flex-col items-center text-center md:flex-row md:items-center md:text-left md:space-x-6 mb-8">
                    <img class="h-28 w-28 rounded-full object-cover shadow-sm border border-gray-300"
                        src="{{ $user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        alt="Profile Picture" />

                    <div class="mt-4 md:mt-0">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->profile->headline ?? 'No headline yet' }}</p>
                        <p class="text-sm text-gray-400">{{ $user->profile->location ?? 'No location' }}</p>
                    </div>
                </div>


                <div class="mb-6">
                    <h4 class="text-lg font-medium text-gray-800">About Me</h4>
                    <p class="text-gray-600 mt-2">{{ $user->profile->summary ?? 'No summary provided.' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h5 class="font-medium text-gray-700">Website</h5>
                        <p class="text-sm text-blue-600">
                            @if ($user->profile->website_url)
                                <a href="{{ $user->profile->website_url }}"
                                    target="_blank">{{ $user->profile->website_url }}</a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h5 class="font-medium text-gray-700">LinkedIn</h5>
                        <p class="text-sm text-blue-600">
                            @if ($user->profile->linkedin_url)
                                <a href="{{ $user->profile->linkedin_url }}"
                                    target="_blank">{{ $user->profile->linkedin_url }}</a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Placeholder tabs -->
        <!-- Tab 2: Work Experience (Now with real data!) -->
        <div x-show="tab === 'experience'" class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Work Experience</h3>
                {{-- <button
                        class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-teal-700 transition-colors text-sm">
                        <i class="ti ti-plus -ml-1 mr-1"></i>
                        Add Experience
                    </button> --}}
            </div>

            <!-- This is the container for the list -->
            <div class="space-y-4">

                {{-- Loop through the user's work experiences --}}
                @forelse ($user->workExperiences as $experience)
                    <div class="border-t border-gray-200 py-4 flex justify-between items-start">
                        <div>
                            {{-- Display data from the database --}}
                            <h4 class="font-bold text-gray-900">{{ $experience->job_title }}</h4>
                            <p class="text-sm text-gray-700">{{ $experience->company_name }}</p>
                            <p class="text-xs text-gray-500">
                                {{-- We use Carbon to format the dates nicely --}}
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} -
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                            </p>

                            {{-- Only show the description if it exists --}}
                            @if ($experience->description)
                                <p class="text-sm text-gray-600 mt-2 whitespace-pre-wrap">{{ $experience->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons (These are still placeholders for now) -->
                        {{-- <div class="flex space-x-2 flex-shrink-0 ml-4">
                                <button class="text-gray-400 hover:text-teal-600" title="Edit"><i class="ti ti-pencil"></i></button>
                                <button class="text-gray-400 hover:text-red-600" title="Delete"><i class="ti ti-trash"></i></button>
                            </div> --}}
                    </div>
                @empty
                    {{-- If there are no experiences, show this message --}}
                    <div class="border-t border-gray-200 py-4 text-center text-gray-500">
                        You haven't added any work experience yet. Click "Add Experience" to get started.
                    </div>
                @endforelse

            </div>
        </div>
        <!-- Tab 3: Education (UI Skeleton) -->
        <div x-show="tab === 'education'" class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Education Journey</h3>
            </div>
            <div class="space-y-4">
                {{-- Loop through the user's education experiences --}}
                @forelse ($user->education as $education)
                    <div class="border-t border-gray-200 py-4 flex justify-between items-start">
                        <div>
                            {{-- Display data from the database --}}
                            <h4 class="font-bold text-gray-900">{{ $education->degree }}</h4>
                            <p class="text-sm text-gray-700">{{ $education->institution }}</p>
                            <p class="text-xs text-gray-500">
                                {{-- We use Carbon to format the dates nicely --}}
                                {{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} -
                                {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('M Y') : 'Present' }}
                            </p>

                            {{-- Only show the description if it exists --}}
                            @if ($education->description)
                                <p class="text-sm text-gray-600 mt-2 whitespace-pre-wrap">{{ $education->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons (These are still placeholders for now) -->
                        {{-- <div class="flex space-x-2 flex-shrink-0 ml-4">
                                <button class="text-gray-400 hover:text-teal-600" title="Edit"><i class="ti ti-pencil"></i></button>
                                <button class="text-gray-400 hover:text-red-600" title="Delete"><i class="ti ti-trash"></i></button>
                            </div> --}}
                    </div>
                @empty
                    {{-- If there are no experiences, show this message --}}
                    <div class="border-t border-gray-200 py-4 text-center text-gray-500">
                        You haven't added any work experience yet. Click "Add Experience" to get started.
                    </div>
                @endforelse

            </div>
        </div>
        <!-- Tab 4: Skills (UI Skeleton) -->
        <!-- Tab 4: Skills (Now with real data!) -->
        <div x-show="tab === 'skills'" class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">

            <div class="max-w-xl">
                <h3 class="text-xl font-bold text-gray-800">Skills</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Showcase your expertise. Recruiters often search by skills, so add the ones you're great at.
                </p>
            </div>


            <!-- List of user's current skills as tags -->
            <div class="mt-6">
                {{-- Check if the user has any skills attached to their profile --}}
                @if ($user->skills->isNotEmpty())
                    <h4 class="text-md font-medium text-gray-700 mb-3">Your Skills</h4>
                    <div class="flex flex-wrap gap-2">
                        {{-- Loop through each skill --}}
                        @foreach ($user->skills as $skill)
                            <div
                                class="bg-teal-100 text-teal-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm hover:bg-teal-200 transition">
                                {{ $skill->name }}
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- This message shows if the user has no skills --}}
                    <p class="text-sm text-gray-500">You haven't added any skills yet.</p>
                @endif
            </div>

        </div>
    </div>



@endsection
