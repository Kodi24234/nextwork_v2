@extends('layouts.company')

@section('title', 'Create Job ')
@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create a New Job Posting</h2>


    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('company.jobs.store') }}" method="POST">
            @csrf
            @include('company.jobs.partials.form-fields')

            <div class="flex justify-end gap-4 mt-6 border-t pt-6">
                <a href="{{ route('company.jobs.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">Post
                    Job</button>
            </div>
        </form>
    </div>
@endsection
