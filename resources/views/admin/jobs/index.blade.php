@extends('layouts.admin')

@section('title', 'All Jobs')

@section('content')
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">

        <!-- Status Dropdown (Updated) -->
        <div>
            <label for="status" class="block text-gray-600 mb-1">Status</label>
            <!-- The relative container for positioning the arrow -->
            <div class="relative">
                <select name="status" id="status"
                    class="w-full border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500 appearance-none">
                    <option value="">All</option>
                    <option value="open" @selected(request('status') === 'open')>Open</option>
                    <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                </select>

            </div>
        </div>

        <!-- Type Dropdown (Updated) -->
        <div>
            <label for="type" class="block text-gray-600 mb-1">Type</label>
            <div class="relative">
                <select name="type" id="type"
                    class="w-full border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500 appearance-none">
                    <option value="">All</option>
                    <option value="Full-time" @selected(request('type') === 'Full-time')>Full-time</option>
                    <option value="Part-time" @selected(request('type') === 'Part-time')>Part-time</option>
                    <option value="Contract" @selected(request('type') === 'Contract')>Contract</option>
                    <option value="Internship" @selected(request('type') === 'Internship')>Internship</option>
                </select>

            </div>
        </div>

        <!-- Company Input (Unchanged, but looks good with the new dropdowns) -->
        <div>
            <label for="company" class="block text-gray-600 mb-1">Company</label>
            <input type="text" name="company" id="company" value="{{ request('company') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                placeholder="Company name">
        </div>

        <!-- Filter Button (Unchanged) -->
        <div class="flex items-end">
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md shadow-sm hover:bg-teal-700 w-full">
                Filter
            </button>
        </div>
    </form>
    <h1 class="text-2xl font-bold text-teal-700 mb-6">All Job Listings</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Posted</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse ($jobs as $job)
                    <tr>
                        <td class="px-4 py-3">{{ $job->title }}</td>
                        <td class="px-4 py-3">{{ $job->company->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $job->type }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-block px-2 py-1 text-xs rounded-full
                                {{ $job->status === 'open' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $job->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No jobs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $jobs->links() }}
    </div>
@endsection
