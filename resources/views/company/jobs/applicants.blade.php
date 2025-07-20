@extends('layouts.company')

@section('title', 'Applicants for Job Posting')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Applicants for "{{ $job->title }}"</h2>
            <p class="text-gray-600">Review the professionals who have applied for this role.</p>
        </div>
        <a href="{{ route('company.jobs.index') }}" class="text-sm text-teal-600 hover:underline">
            ← Back to All Jobs
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 font-semibold">Applicant Name</th>
                    <th class="p-4 font-semibold">Current Headline</th>
                    <th class="p-4 font-semibold">Date Applied</th>
                    <th class="p-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($applicants as $applicant)
                    <tr>
                        <td class="p-4 flex items-center gap-4">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="{{ $applicant->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($applicant->name) . '&color=FFFFFF&background=14B8A6' }}"
                                alt="{{ $applicant->name }}">
                            <span class="font-medium text-gray-800">{{ $applicant->name }}</span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $applicant->profile->headline ?? 'Not specified' }}</td>
                        <td class="p-4 text-gray-600">{{ $applicant->pivot->created_at->format('M d, Y') }}</td>
                        <td class="p-4">
                            {{-- This links to the public profile page we already built! --}}
                            <a href="{{ route('company.jobs.applicants.show', ['job' => $job, 'applicant' => $applicant]) }}"
                                target="_blank" class="text-teal-600 hover:text-teal-800 font-semibold">
                                View Profile →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 p-6">
                            There are no applicants for this job yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $applicants->links() }}
    </div>

@endsection
