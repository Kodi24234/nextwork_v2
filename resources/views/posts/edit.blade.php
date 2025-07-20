@extends('layouts.nextwork')

@section('title', 'Edit Post')

@section('content')

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Your Post</h2>
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PATCH')
                <textarea name="body" rows="5"
                    class="w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">{{ old('body', $post->body) }}</textarea>
                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                <div class="flex justify-end gap-4 mt-4">
                    <a href="{{ route('feed.index') }}"
                        class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</a>
                    <button type="submit"
                        class="bg-teal-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-teal-700">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>

@endsection
