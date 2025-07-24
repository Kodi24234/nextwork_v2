@extends('layouts.nextwork')

@section('title', 'Edit Profile')

@section('content')
    <div x-data="{ tab: 'personal' }" class="max-w-5xl mx-auto bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Your Profile</h2>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-6 text-sm font-medium text-gray-600">
                <button @click="tab = 'personal'" :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'personal' }"
                    class="pb-2">Personal
                    Info</button>
                <button @click="tab = 'experience'"
                    :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'experience' }" class="pb-2">Work
                    Experience</button>
                <button @click="tab = 'education'"
                    :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'education' }"
                    class="pb-2">Education</button>
                <button @click="tab = 'skills'" :class="{ 'text-teal-600 border-b-2 border-teal-600': tab === 'skills' }"
                    class="pb-2">Skills</button>
            </nav>
        </div>

        <!-- Tab 1: Personal Info -->
        <div x-show="tab === 'personal'" class="space-y-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Profile Picture</label>
                        <input type="file" name="profile_picture" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                        <input type="text" name="location"
                            value="{{ old('location', Auth::user()->profile->location ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                    </div>

                    <!-- Headline -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Headline (Bio)</label>
                        <input type="text" name="headline"
                            value="{{ old('headline', Auth::user()->profile->headline ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Website</label>
                        <input type="url" name="website_url"
                            value="{{ old('website_url', Auth::user()->profile->website_url ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">LinkedIn</label>
                        <input type="url" name="linkedin_url"
                            value="{{ old('linkedin_url', Auth::user()->profile->linkedin_url ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                    </div>

                    <!-- About Me -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">About Me</label>
                        <textarea name="summary" rows="5"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none resize-none">{{ old('summary', Auth::user()->profile->summary ?? '') }}</textarea>
                    </div>
                </div>


                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-teal-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-teal-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab 2: Work Experience (Functional UI) -->
        <div x-show="tab === 'experience'" x-data="{
            isAddModalOpen: false,
            isEditModalOpen: false,
            editingExperience: null
        }"
            class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">

            <!-- Header and "Add" Button -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Work Experience</h3>
                <button @click="isAddModalOpen = true"
                    class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-teal-700 transition-colors text-sm">
                    <i class="ti ti-plus -ml-1 mr-1"></i> Add Experience
                </button>
            </div>

            <!-- List of Existing Experiences -->
            <div class="space-y-4">
                @forelse ($user->workExperiences as $experience)
                    <div class="border-t border-gray-200 py-4 flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $experience->job_title }}</h4>
                            <p class="text-sm text-gray-700">{{ $experience->company_name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} -
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                            </p>
                            @if ($experience->description)
                                <p class="text-sm text-gray-600 mt-2 whitespace-pre-wrap">{{ $experience->description }}
                                </p>
                            @endif
                        </div>
                        <!-- ACTION BUTTONS -->
                        <div class="flex space-x-2 flex-shrink-0 ml-4">
                            {{-- Edit Button --}}
                            <button @click="isEditModalOpen = true; editingExperience = {{ json_encode($experience) }}"
                                class="text-gray-400 hover:text-teal-600" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </button>

                            {{-- Delete Button triggers Alpine modal --}}
                            <button @click="$dispatch('open-delete-modal', { id: {{ $experience->id }} })"
                                class="text-gray-400 hover:text-red-600" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="border-t border-gray-200 py-4 text-center text-gray-500">
                        You haven't added any work experience yet.
                    </div>
                @endforelse
            </div>

            <!-- "Add Experience" Modal -->
            <div x-show="isAddModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-2"
                style="display: none;" x-cloak>
                <div @click.away="isAddModalOpen = false"
                    class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 transform transition-all">
                    <form action="{{ route('profile.experience.store') }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Add New Work Experience</h3>

                        <div class="space-y-4">
                            <!-- Job Title -->
                            <div>
                                <x-input-label for="job_title" value="Job Title *" />
                                <x-text-input id="job_title" name="job_title" type="text"
                                    class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500" :value="old('job_title')"
                                    required />
                            </div>

                            <!-- Company Name -->
                            <div>
                                <x-input-label for="company_name" value="Company Name *" />
                                <x-text-input id="company_name" name="company_name" type="text"
                                    class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500" :value="old('company_name')"
                                    required />
                            </div>

                            <!-- Date Range -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_date" value="Start Date *" />
                                    <x-text-input id="start_date" name="start_date" type="date"
                                        class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                        :value="old('start_date')" required />
                                </div>
                                <div>
                                    <x-input-label for="end_date" value="End Date" />
                                    <x-text-input id="end_date" name="end_date" type="date"
                                        class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                        :value="old('end_date')" />
                                    <p class="text-xs text-gray-500 mt-1">Leave blank if this is your current job.</p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Describe your role and accomplishments.</p>
                            </div>
                        </div>

                        <!-- Modal Footer with Buttons -->
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" @click="isAddModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">
                                Save Experience
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- "Edit Experience" Modal  -->
            <div x-show="isEditModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                style="display: none;" x-cloak>
                <div @click.away="isEditModalOpen = false"
                    class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all p-6">
                    {{-- Bind form to experience ID --}}
                    <form x-if="editingExperience" :action="'/profile/experience/' + editingExperience.id" method="POST">
                        @csrf
                        @method('PATCH')
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Work Experience</h3>

                        <div class="space-y-4">
                            <!-- Job Title -->
                            <div>
                                <x-input-label for="edit_job_title" value="Job Title *" />
                                <x-text-input id="edit_job_title" name="job_title" type="text"
                                    class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                    x-model="editingExperience.job_title" required />
                            </div>

                            <!-- Company Name -->
                            <div>
                                <x-input-label for="edit_company_name" value="Company Name *" />
                                <x-text-input id="edit_company_name" name="company_name" type="text"
                                    class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                    x-model="editingExperience.company_name" required />
                            </div>

                            <!-- Date Range -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="edit_start_date" value="Start Date *" />
                                    <x-text-input id="edit_start_date" name="start_date" type="date"
                                        class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                        x-model="editingExperience.start_date" required />
                                </div>
                                <div>
                                    <x-input-label for="edit_end_date" value="End Date" />
                                    <x-text-input id="edit_end_date" name="end_date" type="date"
                                        class="mt-1 block w-full focus:ring-teal-500 focus:border-teal-500"
                                        x-model="editingExperience.end_date" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="edit_description" value="Description" />
                                <textarea id="edit_description" name="description" rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm"
                                    x-model="editingExperience.description"></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" @click="isEditModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- "Delete Experience" Modal  -->
            <div x-data="{ open: false, deleteId: null }" x-on:open-delete-modal.window="open = true; deleteId = $event.detail.id">
                <template x-if="open">
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm max-h-[90vh] overflow-y-auto">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delete Experience</h2>
                            <p class="text-gray-600 mb-6">Are you sure you want to delete this experience?</p>
                            <div class="flex justify-end space-x-3">
                                <button @click="open = false"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                                    Cancel
                                </button>
                                <form :action="`/profile/experience/${deleteId}`" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Tab 3: Education (Full CRUD Functionality) -->
        <div x-show="tab === 'education'" x-data="{
            isAddEducationModalOpen: false,
            isEditEducationModalOpen: false,
            editingEducation: null
        }"
            class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">

            <!-- Header and "Add" Button -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Education</h3>
                <button @click="isAddEducationModalOpen = true"
                    class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-teal-700 transition-colors text-sm">
                    <i class="ti ti-plus -ml-1 mr-1"></i> Add Education
                </button>
            </div>

            <!-- List of Existing Education Records -->
            <div class="space-y-4">
                @forelse ($user->education as $edu)
                    <div class="border-t border-gray-200 py-4 flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $edu->degree }}</h4>
                            <p class="text-sm text-gray-700">{{ $edu->institution_name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} -
                                {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : 'Present' }}
                            </p>
                            @if ($edu->field_of_study)
                                <p class="text-sm text-gray-600 mt-1 italic">{{ $edu->field_of_study }}</p>
                            @endif
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex space-x-2 flex-shrink-0 ml-4">
                            <button @click="isEditEducationModalOpen = true; editingEducation = {{ json_encode($edu) }}"
                                class="text-gray-400 hover:text-teal-600" title="Edit"><i
                                    class="ti ti-pencil"></i></button>
                            <button @click="$dispatch('open-delete-modal', { id: {{ $edu->id }} })"
                                class="text-gray-400 hover:text-red-600" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="border-t border-gray-200 py-4 text-center text-gray-500">
                        You haven't added any education records yet.
                    </div>
                @endforelse
            </div>

            <!-- "Add Education" Modal -->
            <div x-show="isAddEducationModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                style="display: none;" x-cloak>
                <div @click.away="isAddEducationModalOpen = false"
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 transform transition-all max-h-[90vh] overflow-y-auto p-6">
                    <form action="{{ route('profile.education.store') }}" method="POST" class="p-6">
                        @csrf
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Education</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="institution_name" value="Institution Name *" />
                                <x-text-input id="institution_name" name="institution_name" type="text"
                                    class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="degree" value="Degree *" />
                                <x-text-input id="degree" name="degree" type="text" class="mt-1 block w-full"
                                    required placeholder="e.g., Bachelor of Science" />
                            </div>
                            <div>
                                <x-input-label for="field_of_study" value="Field of Study" />
                                <x-text-input id="field_of_study" name="field_of_study" type="text"
                                    class="mt-1 block w-full" placeholder="e.g., Computer Science" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_date" value="Start Date *" />
                                    <x-text-input name="start_date" type="date" class="mt-1 block w-full" required />
                                </div>
                                <div>
                                    <x-input-label for="end_date" value="End Date" />
                                    <x-text-input name="end_date" type="date" class="mt-1 block w-full" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" @click="isAddEducationModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- "Edit Education" Modal -->
            <div x-show="isEditEducationModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                style="display: none;" x-cloak>
                <div @click.away="isEditEducationModalOpen = false"
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 transform transition-all  max-h-[90vh] overflow-y-auto p-6">
                    <form x-if="editingEducation" :action="'/profile/education/' + editingEducation.id" method="POST"
                        class="p-6">
                        @csrf
                        @method('PATCH')
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Education</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="edit_institution_name" value="Institution Name *" />
                                <x-text-input id="edit_institution_name" name="institution_name" type="text"
                                    class="mt-1 block w-full" x-model="editingEducation.institution_name" required />
                            </div>
                            <div>
                                <x-input-label for="edit_degree" value="Degree *" />
                                <x-text-input id="edit_degree" name="degree" type="text" class="mt-1 block w-full"
                                    x-model="editingEducation.degree" required />
                            </div>
                            <div>
                                <x-input-label for="edit_field_of_study" value="Field of Study" />
                                <x-text-input id="edit_field_of_study" name="field_of_study" type="text"
                                    class="mt-1 block w-full" x-model="editingEducation.field_of_study" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="edit_start_date" value="Start Date *" />
                                    <x-text-input name="start_date" type="date" class="mt-1 block w-full"
                                        x-model="editingEducation.start_date" required />
                                </div>
                                <div>
                                    <x-input-label for="edit_end_date" value="End Date" />
                                    <x-text-input name="end_date" type="date" class="mt-1 block w-full"
                                        x-model="editingEducation.end_date" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" @click="isEditEducationModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- "Delete Experience" Modal  -->
            <div x-data="{ open: false, deleteId: null }" x-on:open-delete-modal.window="open = true; deleteId = $event.detail.id">
                <template x-if="open">
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm max-h-[90vh] overflow-y-auto">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delete Education</h2>
                            <p class="text-gray-600 mb-6">Are you sure you want to delete this education?</p>
                            <div class="flex justify-end space-x-3">
                                <button @click="open = false"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                                    Cancel
                                </button>
                                <form :action="`/profile/education/${deleteId}`" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Tab 4: Skills -->
        <div x-show="tab === 'skills'" class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">

            <div class="max-w-xl">
                <h3 class="text-xl font-bold text-gray-800">Skills</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Showcase your expertise. Recruiters often search by skills, so add the ones you're great at.
                </p>
            </div>

            <!-- Form for adding a new skill -->
            <form action="{{ route('profile.skills.store') }}" method="POST" class="mt-6 flex items-center gap-4">
                @csrf
                <div class="flex-grow">
                    <x-input-label for="skill_name" value="Add a new skill" class="sr-only" />
                    <x-text-input id="skill_name" name="name" type="text" class="block w-full"
                        placeholder="e.g., Laravel, Project Management" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <button type="submit"
                    class="bg-teal-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-teal-700 transition-colors text-sm shrink-0">
                    Add Skill
                </button>
            </form>

            <!-- List of user's current skills as tags -->
            <div class="mt-6">
                @if ($user->skills->isNotEmpty())
                    <h4 class="text-md font-medium text-gray-700 mb-3">Your Skills</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($user->skills as $skill)
                            <div class="flex items-center bg-teal-100 text-teal-800 text-sm font-medium rounded-full">
                                <span class="pl-3 pr-2 py-1">{{ $skill->name }}</span>

                                {{-- Mini-form for deleting a skill --}}
                                <form action="{{ route('profile.skills.destroy', $skill) }}" method="POST"
                                    class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-1 mr-2 text-teal-600 hover:text-teal-800"
                                        title="Remove {{ $skill->name }}">
                                        ×
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">You haven't added any skills yet.</p>
                @endif
            </div>

        </div>

    </div>
@endsection
