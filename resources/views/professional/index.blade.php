@extends('layouts.nextwork')

@section('title', 'Browse Professionals')

@section('content')


    <div class="max-w-7xl mx-auto mb-20">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Connect with Professionals</h2>

        {{-- Grid for displaying user cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($professionals as $professional)
                <div
                    class="bg-white rounded-xl shadow-md border border-gray-100 text-center p-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <a href="{{ route('professionals.show', $professional) }}">
                        {{-- Profile Picture --}}
                        <img class="h-24 w-24 rounded-full object-cover mx-auto mb-4 border-2 border-gray-200"
                            src="{{ $professional->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($professional->name) . '&color=FFFFFF&background=14B8A6&size=128' }}"
                            alt="{{ $professional->name }}">

                        {{-- Name --}}
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $professional->name }}
                        </h3>

                        {{-- Headline --}}
                        <p class="text-sm text-gray-500 mt-1 h-10 overflow-hidden">
                            {{ $professional->profile->headline ?? 'Nextwork Professional' }}
                        </p>
                    </a>



                    <div class="mt-4 space-y-2">
                        @php
                            // Check if a connection exists for this professional in database
                            $connection = $connections->get($professional->id);
                            $status = $connection->status ?? null;
                            $isRequester = $connection && $connection->requester_id == auth()->id();
                        @endphp


                        <a href="{{ route('professionals.show', $professional) }}"
                            class="w-full block bg-orange-50 text-orange-700 font-semibold px-4 py-2 rounded-lg hover:bg-orange-100 transition-colors text-center">
                            View Profile
                        </a>


                        @if ($status === 'accepted')
                            <button
                                class="w-full bg-gray-100 text-gray-600 font-semibold px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2"
                                disabled>
                                <i class="ti ti-users"></i> Connected
                            </button>
                        @elseif($status === 'pending' && $isRequester)
                            <button
                                class="w-full bg-gray-100 text-gray-600 font-semibold px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2"
                                disabled>
                                <i class="ti ti-clock-hour-4"></i> Pending
                            </button>
                        @elseif($status === 'pending' && !$isRequester)
                            <form action="{{ route('connections.update', $connection) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full bg-green-100 text-green-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-200">
                                    Accept Request
                                </button>
                            </form>
                        @else
                            <form action="{{ route('connections.store', $professional) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $professional->id }}">
                                <button type="submit"
                                    class="w-full bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-orange-700">
                                    Connect
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-12">
                    <p>No other professionals found at this time.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-8 mb-20">
            {{ $professionals->links() }}
        </div>
    </div>

@endsection
