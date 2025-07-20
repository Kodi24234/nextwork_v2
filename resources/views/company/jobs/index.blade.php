@extends('layouts.company')
@section('title', 'Manage Jobs')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Your Job Listings</h2>
        <a href="{{ route('company.jobs.create') }}"
            class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-teal-700 transition-colors">
            <i class="ti ti-plus -ml-1 mr-1"></i> Post a New Job
        </a>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="flex items-start justify-between bg-green-50 border border-green-400 text-green-800 text-sm px-4 py-3 rounded-lg mb-6"
            role="alert">
            <div class="flex items-center">
                <i class="ti ti-check mr-2 text-lg text-green-600"></i>
                <span>{{ session('status') }}</span>
            </div>
            <button @click="show = false" class="text-lg leading-none text-green-600 hover:text-green-800 ml-4">
                &times;
            </button>
        </div>
    @endif


    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 font-semibold">Title</th>
                    <th class="p-4 font-semibold">Location</th>
                    <th class="p-4 font-semibold">Type</th>
                    <th class="p-4 font-semibold">Applicants</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($jobs as $job)
                    <tr>
                        <td class="p-4 font-medium text-gray-800">{{ $job->title }}</td>
                        <td class="p-4 text-gray-600">{{ $job->location }}</td>
                        <td class="p-4 text-gray-600">{{ $job->type }}</td>
                        <td class="p-4">
                            <a href="{{ route('company.jobs.applicants', $job) }}"
                                class="text-teal-600 font-medium hover:underline">
                                View ({{ $job->applicants_count }})
                            </a>
                        </td>


                        <td class="p-4">
                            @if ($job->status == 'open')
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full shadow-sm">
                                    <i class="ti ti-check text-xs"></i> Open
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full shadow-sm">
                                    <i class="ti ti-x text-xs"></i> Closed
                                </span>
                            @endif
                        </td>
                        <td class="p-4 flex items-center gap-4">
                            <a href="{{ route('company.jobs.edit', $job) }}" title="Edit"
                                class="text-teal-600 hover:text-teal-800">
                                <i class="ti ti-edit"></i>
                            </a>
                            <div x-data="{ open: false }">
                                <button @click="open = true" title="Delete" class="text-red-600 hover:text-red-800">
                                    <i class="ti ti-trash"></i>
                                </button>

                                <!-- Modal -->
                                <div x-show="open" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div @click.away="open = false"
                                        class="bg-white rounded-lg p-6 shadow-lg max-w-md w-full">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
                                        <p class="text-gray-600 mb-6">Are you sure you want to delete this job posting? This
                                            action cannot be undone.</p>

                                        <div class="flex justify-end gap-3">
                                            <button @click="open = false"
                                                class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Cancel</button>

                                            <form action="{{ route('company.jobs.destroy', $job) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded">
                                                    Confirm Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-12">
                            <i class="ti ti-briefcase-off text-4xl text-teal-400 mb-2"></i>
                            <p class="font-semibold text-lg">No job listings yet.</p>
                            <p class="text-sm text-gray-400">Post your first job to start hiring great talent!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $jobs->links() }}
    </div>
@endsection
