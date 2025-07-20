@extends('layouts.admin')

@section('title', 'All Users')

@section('content')
    <h1 class="text-2xl font-bold text-teal-700 mb-6">All Users</h1>

    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div>
            <label class="block text-gray-600 mb-1">Role</label>
            <select name="role" class="w-full border-gray-300 rounded-md">
                <option value="">All</option>
                <option value="professional" @selected(request('role') === 'professional')>Professional</option>
                <option value="company" @selected(request('role') === 'company')>Company</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Email"
                class="w-full border-gray-300 rounded-md" />
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="w-full px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">Filter</button>
        </div>
    </form>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Registered</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->roles->pluck('name')->first() ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
