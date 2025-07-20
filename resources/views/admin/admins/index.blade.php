@extends('layouts.admin')

@section('title', 'Manage Admins')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-teal-700">Manage Admins</h1>
        <a href="{{ route('admin.admins.create') }}"
            class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
            + Add Admin
        </a>
    </div>

    @if (session('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="text-red-600 mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Super Admin</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @foreach ($admins as $admin)
                    <tr>
                        <td class="px-4 py-3">{{ $admin->name }}</td>
                        <td class="px-4 py-3">{{ $admin->email }}</td>
                        <td class="px-4 py-3">
                            @if ($admin->is_super_admin)
                                <span class="text-xs text-green-600 font-medium">Yes</span>
                            @else
                                <span class="text-xs text-gray-500">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $admin->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3">
                            @if (!$admin->is_super_admin && auth()->id() !== $admin->id)
                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                    onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">
                                        Remove
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">Protected</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
