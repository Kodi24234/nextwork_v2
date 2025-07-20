<div class="max-w-5xl mx-auto">
    <!-- Profile Header Card -->
    <div class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <img class="h-32 w-32 rounded-full object-cover ring-4 ring-teal-100"
                    src="{{ $user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=FFFFFF&background=14B8A6&size=128' }}"
                    alt="{{ $user->name }}">
            </div>

            <!-- Info and Action Button -->
            <div class="flex-grow text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-lg text-gray-600 mt-1">{{ $user->profile->headline ?? 'Nextwork Professional' }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $user->profile->location ?? 'Location not specified' }}</p>

                <!-- In resources/views/professional/show.blade.php -->

                {{-- This is the div that contains the action button --}}
                <div class="mt-4">

                    {{-- First, check if the logged-in user is a professional AND is not viewing their own profile --}}
                    @if (Auth::check() && Auth::user()->hasRole('professional') && Auth::id() !== $user->id)
                        @switch($connectionStatus ?? null)
                            @case(null)
                                {{-- No connection exists. Show the "Connect" button. --}}

                                <form action="{{ route('connections.store') }}" method="POST">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    @csrf
                                    <button type="submit"
                                        class="bg-teal-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-teal-700 transition-colors">
                                        <i class="ti ti-user-plus mr-2"></i>Connect
                                    </button>
                                </form>
                            @break

                            @case('pending')
                                {{-- Auth user has sent a request, but it's not accepted yet. --}}
                                <form action="{{ route('connections.destroy', $connection) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-gray-200 text-gray-600 font-bold py-2 px-6 rounded-lg cursor-pointer hover:bg-gray-300"
                                        title="Cancel Request">
                                        <i class="ti ti-clock-hour-4 mr-2"></i>Request Sent
                                    </button>
                                </form>
                            @break

                            @case('pending_approval')
                                {{-- The other user has sent a request. Show Accept/Decline. --}}
                                <div class="flex items-center gap-4">
                                    <form action="{{ route('connections.update', $connection) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-teal-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-teal-700 transition-colors">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('connections.destroy', $connection) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            @break

                            @case('accepted')
                                {{-- The users are connected. --}}
                                <div class="flex items-center gap-4">
                                    <button class="bg-teal-100 text-teal-800 font-bold py-2 px-6 rounded-lg flex items-center"
                                        disabled>
                                        <i class="ti ti-users mr-2"></i>Connected
                                    </button>
                                    <form action="{{ route('connections.destroy', $connection) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to remove this connection?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600"
                                            title="Remove Connection">
                                            <i class="ti ti-user-x"></i>
                                        </button>
                                    </form>
                                </div>
                            @break

                            {{-- We don't need the other cases ('declined', 'blocked', 'default') because the outer @if handles them.
                                 If the status is anything else, or if the viewer is a company, nothing will be rendered. --}}
                        @endswitch
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (About & Skills) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- About Section -->
            @if ($user->profile->summary)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">About</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $user->profile->summary }}</p>
                </div>
            @endif

            <!-- Work Experience Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Experience</h3>
                <div class="space-y-6">
                    @forelse ($user->workExperiences as $experience)
                        <div class="flex gap-4">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-briefcase text-2xl text-gray-500"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $experience->job_title }}</h4>
                                <p class="text-sm text-gray-700">{{ $experience->company_name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} -
                                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No work experience listed.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column (Skills & Education) -->
        <div class="space-y-8">
            <!-- Skills Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Skills</h3>
                @if ($user->skills->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($user->skills as $skill)
                            <span
                                class="bg-teal-100 text-teal-800 text-sm font-medium px-3 py-1 rounded-full">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No skills listed.</p>
                @endif
            </div>

            <!-- Education Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Education</h3>
                <div class="space-y-6">
                    @forelse ($user->education as $edu)
                        <div class="flex gap-4">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-school text-2xl text-gray-500"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $edu->institution_name }}</h4>
                                <p class="text-sm text-gray-700">{{ $edu->degree }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} -
                                    {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Present' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No education listed.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
