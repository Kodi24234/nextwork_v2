@extends('layouts.admin')

@section('title', 'Manage Admins')

@section('content')
    <!-- Header with Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Management</h1>
            <p class="text-sm text-gray-600">Manage administrator accounts and permissions</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm text-center">
                    <div class="text-xs text-gray-500">Total Admins</div>
                    <div class="text-lg font-bold text-gray-900">{{ $admins->count() }}</div>
                </div>
                <div class="bg-red-50 px-3 py-2 rounded-lg border border-red-200 shadow-sm text-center">
                    <div class="text-xs text-red-600">Super Admins</div>
                    <div class="text-lg font-bold text-red-700">{{ $admins->where('is_super_admin', true)->count() }}</div>
                </div>
            </div>

            <a href="{{ route('admin.admins.create') }}"
                class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Admin
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button"
                            class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button"
                            class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Security Warning for Super Admin Actions -->
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-amber-800">Security Notice</h3>
                <div class="mt-1 text-sm text-amber-700">
                    <p>Super administrators and your own account are protected from deletion. Only grant admin privileges to
                        trusted individuals.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Admins Table -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Administrator Accounts</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $admins->count() }}
                administrator{{ $admins->count() !== 1 ? 's' : '' }} registered</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Administrator
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Permissions
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
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Administrator Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($admin->avatar)
                                            <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->name }}"
                                                class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div
                                                class="h-10 w-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-semibold text-gray-900">{{ $admin->name }}</div>
                                            @if (auth()->id() === $admin->id)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    You
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center text-sm text-gray-900">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $admin->email }}
                                </div>
                            </td>

                            <!-- Permissions -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if ($admin->is_super_admin)
                                        <div
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Super Admin
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Regular Admin
                                        </div>
                                    @endif
                                </div>
                            </td>



                            <!-- Joined -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $admin->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $admin->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right" x-data="{ confirmDelete: false }">
                                <div class="flex items-center justify-end space-x-2">
                                    @if (!$admin->is_super_admin && auth()->id() !== $admin->id)
                                        <!-- Delete Button (triggers modal) -->
                                        <button @click="confirmDelete = true"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 rounded-lg transition-colors duration-150"
                                            title="Remove Admin">
                                            <i class="ti ti-trash text-[14px]"></i>
                                        </button>

                                        <!-- Custom Delete Confirmation Modal -->
                                        <div x-show="confirmDelete" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 text-left">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Confirm Deletion</h3>
                                                <p class="text-sm text-gray-600 mb-4">
                                                    Are you sure you want to remove
                                                    <strong>{{ $admin->name }}</strong> as an administrator? This action
                                                    cannot be undone.
                                                </p>
                                                <div class="flex justify-end gap-3">
                                                    <button @click="confirmDelete = false"
                                                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 bg-gray-100 rounded-md">
                                                        Cancel
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('admin.admins.destroy', $admin) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md shadow">
                                                            Yes, Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center text-xs text-gray-400 gap-1">
                                            <i class="ti ti-lock text-[14px]"></i>
                                            <span>Protected</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No administrators found</h3>
                                    <p class="text-gray-500 mb-4">Get started by adding your first administrator.</p>
                                    <a href="{{ route('admin.admins.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                        Add First Admin
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Management Guide -->
    <div class="mt-6 bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Management Guide</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-2">👑 Super Administrators</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Full system access and control</li>
                    <li>• Can manage all users and content</li>
                    <li>• Cannot be deleted by other admins</li>
                    <li>• Can promote/demote other admins</li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-2">👤 Regular Administrators</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Limited administrative access</li>
                    <li>• Can manage users and content</li>
                    <li>• Can be removed by super admins</li>
                    <li>• Cannot modify other admin accounts</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
