@extends('layouts.admin')

@section('title', 'All Users')

@section('content')
    <!-- Header with Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Users</h1>
            <p class="text-sm text-gray-600">Manage and monitor all registered users</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm text-center">
                    <div class="text-xs text-gray-500">Total</div>
                    <div class="text-lg font-bold text-gray-900">{{ $users->total() }}</div>
                </div>
                <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-200 shadow-sm text-center">
                    <div class="text-xs text-blue-600">Professionals</div>
                    <div class="text-lg font-bold text-blue-700">
                        {{ $users->where('roles.0.name', 'professional')->count() }}</div>
                </div>
                <div class="bg-green-50 px-3 py-2 rounded-lg border border-green-200 shadow-sm text-center">
                    <div class="text-xs text-green-600">Companies</div>
                    <div class="text-lg font-bold text-green-700">{{ $users->where('roles.0.name', 'company')->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Filter Users</h2>
            <span class="text-sm text-gray-500">{{ $users->count() }} of {{ $users->total() }} users</span>
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Role Filter -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">User Role</label>
                <select name="role" id="role"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                    <option value="">All Roles</option>
                    <option value="professional" @selected(request('role') === 'professional')>
                        👤 Professional
                    </option>
                    <option value="company" @selected(request('role') === 'company')>
                        🏢 Company
                    </option>
                    <option value="admin" @selected(request('role') === 'admin')>
                        ⚡ Admin
                    </option>
                </select>
            </div>

            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, or phone..."
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

                <a href="{{ route('admin.users.index') }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Enhanced Users Table -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>

                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Registered
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- User Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->profile->profile_picture_path) }}"
                                                alt="{{ $user->name }}"
                                                class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div
                                                class="h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>


                            <!-- Contact Info -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $user->email }}
                                    </div>
                                    @if ($user->phone)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $user->phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Role  -->
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    @php
                                        $role = $user->roles->pluck('name')->first();
                                        $roleConfig = [
                                            'admin' => ['bg-red-100', 'text-red-800', '⚡'],
                                            'company' => ['bg-green-100', 'text-green-800', '🏢'],
                                            'professional' => ['bg-blue-100', 'text-blue-800', '👤'],
                                        ];
                                        $config = $roleConfig[$role] ?? ['bg-gray-100', 'text-gray-800', '❓'];
                                    @endphp

                                    <div
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config[0] }} {{ $config[1] }}">
                                        <span class="mr-1">{{ $config[2] }}</span>
                                        {{ ucfirst($role ?? 'Unknown') }}
                                    </div>


                                </div>
                            </td>



                            <!-- Registered -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button
                                        class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
                                        title="View Profile">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <button
                                        class="inline-flex items-center p-2 text-gray-400 hover:text-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
                                        title="Edit User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <div class="relative">
                                        <button
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
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
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                    <p class="text-gray-500 mb-4">No users match your current filters.</p>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                        View All Users
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Enhanced Pagination -->
    @if ($users->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            <div>
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
@endsection
