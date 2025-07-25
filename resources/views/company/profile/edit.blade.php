@extends('layouts.company')

@section('title', 'Company Profile')
@section('page-title', 'Company Profile')
@section('content')
    <div class="max-w-5xl mx-auto">


        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Company Profile</h2>
                <p class="text-gray-600 text-lg">Manage your company information and branding</p>
            </div>
            <a href="{{ route('company.dashboard') }}"
                class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 lg:w-auto w-fit">
                <i class="ti ti-arrow-left text-sm mr-2"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'company-profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mb-8 shadow-sm"
                role="alert">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="ti ti-check text-green-600 text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800">Profile Updated!</p>
                        <p class="text-green-700 text-sm">Your company profile has been successfully updated.</p>
                    </div>
                </div>
                <button @click="show = false"
                    class="flex-shrink-0 p-1 text-green-600 hover:text-green-800 hover:bg-green-100 rounded-lg transition-colors">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
        @endif

        <!-- Main Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data"
                x-data="{ logoPreview: null, dragOver: false }" class="divide-y divide-gray-200">
                @csrf
                @method('PATCH')

                <!-- Company Logo Section -->
                <div class="p-6 lg:p-8">
                    <div class="flex items-start gap-6">
                        <div class="flex flex-col items-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Logo</h3>

                            <!-- Logo Display -->
                            <div class="relative group">
                                <div
                                    class="w-32 h-32 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden transition-all duration-200 group-hover:border-teal-400 group-hover:bg-teal-50">
                                    @if ($company->logo_path)
                                        <img class="w-full h-full object-contain p-2"
                                            src="{{ asset('storage/' . $company->logo_path) }}"
                                            alt="{{ $company->name }} Logo" x-show="!logoPreview">
                                    @else
                                        <div class="text-center" x-show="!logoPreview">
                                            <i class="ti ti-building-skyscraper text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-xs text-gray-500">No logo uploaded</p>
                                        </div>
                                    @endif

                                    <!-- Preview new image -->
                                    <img x-show="logoPreview" :src="logoPreview"
                                        class="w-full h-full object-contain p-2" alt="Logo Preview">
                                </div>

                                <!-- Upload overlay -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <p class="text-white text-sm font-medium">Click to change</p>
                                </div>
                            </div>

                            <!-- Upload Button -->
                            <label for="logo"
                                class="mt-4 cursor-pointer inline-flex items-center px-4 py-2 bg-white text-gray-700 font-medium border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus-within:ring-2 focus-within:ring-teal-500 focus-within:ring-offset-2">
                                <i class="ti ti-upload text-sm mr-2"></i>
                                {{ $company->logo_path ? 'Change Logo' : 'Upload Logo' }}
                            </label>

                            <input type="file" name="logo" id="logo" accept="image/*" class="hidden"
                                @change="
                                       const file = $event.target.files[0];
                                       if (file) {
                                           const reader = new FileReader();
                                           reader.onload = (e) => logoPreview = e.target.result;
                                           reader.readAsDataURL(file);
                                       }
                                   ">

                            <p class="text-xs text-gray-500 mt-2 text-center max-w-xs">
                                Recommended: Square PNG or JPG up to 5MB
                            </p>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2 text-center" />
                        </div>



                    </div>
                </div>

                <!-- Company Information Section -->
                <div class="p-6 lg:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Company Information</h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div class="lg:col-span-2">
                            <x-input-label for="name" class="text-sm font-medium text-gray-700 mb-2">
                                Company Name *
                            </x-input-label>
                            <x-text-input id="name" name="name" type="text"
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors text-base"
                                :value="old('name', $company->name)" required placeholder="Enter your company name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Website URL -->
                        <div>
                            <x-input-label for="website_url" class="text-sm font-medium text-gray-700 mb-2">
                                Website URL
                            </x-input-label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ti ti-world text-gray-400 text-sm"></i>
                                </div>
                                <x-text-input id="website_url" name="website_url" type="url"
                                    class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors text-base"
                                    :value="old('website_url', $company->website_url)" placeholder="https://yourcompany.com" />
                            </div>
                            <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
                        </div>

                        <!-- Industry -->
                        <div>
                            <x-input-label for="industry" class="text-sm font-medium text-gray-700 mb-2">
                                Industry
                            </x-input-label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ti ti-building text-gray-400 text-sm"></i>
                                </div>
                                <x-text-input id="industry" name="industry" type="text"
                                    class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors text-base"
                                    :value="old('industry', $company->industry)" placeholder="e.g., Software Development, Healthcare" />
                            </div>
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                        </div>

                        <!-- About Section -->
                        <div class="lg:col-span-2">
                            <x-input-label for="about" class="text-sm font-medium text-gray-700 mb-2">
                                About Company
                            </x-input-label>
                            <textarea id="about" name="about" rows="6"
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors text-base resize-none"
                                placeholder="Tell potential candidates about your company culture, mission, and what makes you unique...">{{ old('about', $company->about) }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                <span x-text="$el.previousElementSibling.value.length"></span>/1000 characters
                            </p>
                            <x-input-error :messages="$errors->get('about')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <!-- Action Buttons -->
                <div class="px-4 py-4 lg:px-8 lg:py-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col justify-end sm:flex-row sm:justify-between sm:items-center gap-4">

                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto ">
                            <!-- Reset Button -->
                            <button type="button" onclick="window.location.reload()"
                                class="inline-flex items-center justify-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="ti ti-refresh text-sm mr-2"></i>
                                Reset Changes
                            </button>

                            <!-- Save Button -->
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl shadow-md hover:from-teal-600 hover:to-teal-700 hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <i class="ti ti-device-floppy text-sm mr-2"></i>
                                Save Changes
                            </button>
                        </div>

                    </div>
                </div>

            </form>
        </div>

        <!-- Additional Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <!-- Profile Completeness -->


            <!-- Quick Stats -->

        </div>
    </div>

    <style>
        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: transparent;
        }

        textarea::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.4);
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.6);
        }
    </style>
@endsection
