@extends('layouts.nextwork')

@section('title', 'CV Builder')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Your CV Builder</h2>
            <p class="text-gray-600 mb-6">Preview your profile info and edit sections before downloading your CV.</p>

            {{-- Name --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Name:</h3>
                <p class="text-gray-800">{{ Auth::user()->name }}</p>
            </div>

            {{-- Headline (inline edit) --}}
            <div x-data="{ editing: false, value: '{{ Auth::user()->profile->headline }}' }" class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Headline:</h3>
                <template x-if="!editing">
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800" x-text="value || 'Not added yet'"></p>
                        <button @click="editing = true" class="text-sm text-teal-600 hover:underline">Edit</button>
                    </div>
                </template>
                <template x-if="editing">
                    <form method="POST" action="{{ route('cv.update') }}" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="field" value="headline">
                        <input type="text" name="value" x-model="value"
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="button" @click="editing = false"
                                class="text-sm text-gray-600 hover:underline">Cancel</button>
                            <button type="submit"
                                class="text-sm bg-teal-600 text-white px-4 py-1 rounded hover:bg-teal-700">Save</button>
                        </div>
                    </form>
                </template>
            </div>

            {{-- Summary (inline edit) --}}
            <div x-data="{ editing: false, value: @js(Auth::user()->profile->summary) }" class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Summary:</h3>
                <template x-if="!editing">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-800" x-text="value || 'Not added yet'"></p>
                        <button @click="editing = true" class="text-sm text-teal-600 hover:underline mt-1">Edit</button>
                    </div>
                </template>
                <template x-if="editing">
                    <form method="POST" action="{{ route('cv.update') }}" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="field" value="summary">
                        <textarea name="value" x-model="value" rows="3"
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-teal-500 focus:border-teal-500"></textarea>
                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="button" @click="editing = false"
                                class="text-sm text-gray-600 hover:underline">Cancel</button>
                            <button type="submit"
                                class="text-sm bg-teal-600 text-white px-4 py-1 rounded hover:bg-teal-700">Save</button>
                        </div>
                    </form>
                </template>
            </div>

            {{-- Work Experience --}}
            <div class="mt-10">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Work Experience</h3>
                @forelse (Auth::user()->workExperiences as $exp)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-700">{{ $exp->job_title }}</h4>
                        <p class="text-sm text-gray-600">{{ $exp->company_name }}</p>
                        <p class="text-sm text-gray-500">{{ $exp->start_date }} – {{ $exp->end_date }}</p>
                        <p class="mt-2 text-gray-700">{{ $exp->description }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No work experience added yet.</p>
                @endforelse
            </div>

            {{-- Education --}}
            <div class="mt-10">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Education</h3>
                @forelse (Auth::user()->education as $edu)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-700">{{ $edu->degree }} in {{ $edu->field_of_study }}
                        </h4>
                        <p class="text-sm text-gray-600">{{ $edu->institution_name }}</p>
                        <p class="text-sm text-gray-500">{{ $edu->start_date }} – {{ $edu->end_date }}</p>
                        <p class="mt-2 text-gray-700">{{ $edu->description }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No education history added yet.</p>
                @endforelse
            </div>

            {{-- Skills --}}
            <div class="mt-10">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Skills</h3>
                @if (Auth::user()->skills->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach (Auth::user()->skills as $skill)
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No skills added yet.</p>
                @endif
            </div>

            {{-- Final Actions --}}
            <div class="flex justify-end mt-10">
                <a href="{{ route('cv.preview') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-md">
                    Preview CV
                </a>
            </div>
        </div>
    </div>
@endsection
