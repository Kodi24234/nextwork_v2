@extends('layouts.admin')

@section('title', 'All Companies')

@section('content')
    <!-- Header with Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Companies</h1>
            <p class="text-sm text-gray-600">Manage and monitor all registered companies</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
                <div class="text-sm text-gray-500">Total Companies</div>
                <div class="text-xl font-bold text-gray-900">{{ $companies->total() }}</div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Filter Companies</h2>
            <span class="text-sm text-gray-500">{{ $companies->count() }} of {{ $companies->total() }} companies</span>
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Companies</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Search by company name, industry, or owner email..."
                        class="w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm" />
                </div>
            </div>



            <!-- Action Buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.121A1 1 0 013 6.414V4z" />
                    </svg>
                    Filter
                </button>

                <a href="{{ route('admin.companies.index') }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Enhanced Company Table -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Industry & Website
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Owner
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Activity
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Company Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($company->logo_path)
                                            <img src="{{ asset('storage/' . $company->logo_path) }}"
                                                alt="{{ $company->name }} Logo"
                                                class="h-12 w-12 rounded-lg object-cover border border-gray-200 shadow-sm">
                                        @else
                                            <div
                                                class="h-12 w-12 bg-gradient-to-br from-teal-400 to-teal-600 rounded-lg flex items-center justify-center shadow-sm">
                                                <span class="text-white font-semibold text-lg">
                                                    {{ strtoupper(substr($company->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $company->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Industry & Website -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if ($company->industry)
                                        <div
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $company->industry }}
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">No industry set</span>
                                    @endif

                                    @if ($company->website_url)
                                        <div>
                                            <a href="{{ $company->website_url }}" target="_blank"
                                                class="inline-flex items-center text-xs text-teal-600 hover:text-teal-800 transition-colors duration-150">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                {{ parse_url($company->website_url, PHP_URL_HOST) }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Owner -->
                            <td class="px-6 py-4">
                                @if ($company->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-700">
                                                    {{ strtoupper(substr($company->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $company->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $company->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">No owner assigned</span>
                                @endif
                            </td>

                            <!-- Activity -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-gray-900">{{ $company->jobs->count() }}
                                        </div>
                                        <div class="text-xs text-gray-500">Jobs</div>
                                    </div>
                                    @if ($company->jobs->where('status', 'open')->count() > 0)
                                        <div class="text-center">
                                            <div class="text-sm font-semibold text-green-600">
                                                {{ $company->jobs->where('status', 'open')->count() }}</div>
                                            <div class="text-xs text-gray-500">Active</div>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Joined -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $company->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $company->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button
                                        class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
                                        title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <div class="relative">
                                        <button
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
                                            title="More Options">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No companies found</h3>
                                    <p class="text-gray-500 mb-4">No companies match your current filters.</p>
                                    <a href="{{ route('admin.companies.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                        View All Companies
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!--  Pagination -->
    @if ($companies->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }}
                companies
            </div>
            <div>
                {{ $companies->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
@endsection
