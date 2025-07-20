@extends('layouts.admin')

@section('title', 'Add Admin')

@section('content')
    <h1 class="text-2xl font-bold text-teal-700 mb-6">Add New Admin</h1>

    <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-4 max-w-lg">
        @csrf

        <div>
            <label class="block mb-1 text-sm text-gray-600">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full border-gray-300 rounded-md" />
            @error('name')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm text-gray-600">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border-gray-300 rounded-md" />
            @error('email')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm text-gray-600">Password</label>
            <input type="password" name="password" required class="w-full border-gray-300 rounded-md" />
            @error('password')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm text-gray-600">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border-gray-300 rounded-md" />
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">
                Create Admin
            </button>
        </div>
    </form>
@endsection
