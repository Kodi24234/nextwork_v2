@extends('layouts.admin')

@section('title', 'All Jobs')

@section('content')

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filter Jobs</h2>

        {{-- Filter summary badges --}}
        @if (request()->hasAny(['status', 'type', 'company']))
            <div class="flex flex-wrap gap-2 mb-4 text-sm">
                @if (request('status'))
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full">
                        Status: {{ ucfirst(request('status')) }}
                    </span>
                @endif

                @if (request('type'))
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                        Type: {{ request('type') }}
                    </span>
                @endif

                @if (request('company'))
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">
                        Company: {{ request('company') }}
                    </span>
                @endif
            </div>
        @endif

        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <!-- Status Dropdown -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="open" @selected(request('status') === 'open')>Open</option>
                    <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                </select>
            </div>

            <!-- Type Dropdown -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" id="type"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option value="">All Types</option>
                    <option value="Full-time" @selected(request('type') === 'Full-time')>Full-time</option>
                    <option value="Part-time" @selected(request('type') === 'Part-time')>Part-time</option>
                    <option value="Contract" @selected(request('type') === 'Contract')>Contract</option>
                    <option value="Internship" @selected(request('type') === 'Internship')>Internship</option>
                </select>
            </div>

            <!-- Company Name Input -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                <input type="text" name="company" id="company" value="{{ request('company') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm"
                    placeholder="Search by company name">
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.121A1 1 0 013 6.414V4z" />
                    </svg>
                    Filter
                </button>
            </div>

            <!-- Clear Button -->
            <div class="flex items-end">
                <a href="{{ route('admin.jobs.index') }}"
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear
                </a>
            </div>
        </form>
    </div>



    <!-- Jobs Table -->
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Job Details
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posted
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jobs as $job)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                @if ($job->location)
                                    <div class="text-sm text-gray-500">📍 {{ $job->location }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $job->company->name ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $job->type === 'Full-time'
                                        ? 'bg-blue-100 text-blue-800'
                                        : ($job->type === 'Part-time'
                                            ? 'bg-green-100 text-green-800'
                                            : ($job->type === 'Contract'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-purple-100 text-purple-800')) }}">
                                    {{ $job->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $job->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div>{{ $job->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6.586a1 1 0 01-.293.707L16 17H8l-2.707-2.707A1 1 0 015 13.586V7a2 2 0 012-2V4" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs found</h3>
                                    <p class="text-gray-500">Try adjusting your filters or create a new job listing.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($jobs->hasPages())
        <div class="mt-6">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
