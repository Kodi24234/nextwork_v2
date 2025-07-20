@extends('layouts.company')

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('company.dashboard') }}"
            class="inline-flex items-center text-sm text-teal-600 font-medium hover:underline mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
        </a>

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Your Company Profile</h2>

        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Success Message -->
                @if (session('status') === 'company-profile-updated')
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Success</p>
                        <p>Your company profile has been updated.</p>
                    </div>
                @endif

                <!-- Company Logo Section -->
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6 mb-8 pb-8 border-b">
                    @if ($company->logo_path)
                        <img class="h-24 w-24 rounded-lg object-contain border p-1"
                            src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }} Logo">
                    @else
                        <div class="h-24 w-24 rounded-lg bg-gray-100 flex items-center justify-center border">
                            <i class="ti ti-building-skyscraper text-4xl text-gray-400"></i>
                        </div>
                    @endif

                    <div class="flex-grow">
                        <label for="logo"
                            class="cursor-pointer bg-white text-gray-700 font-semibold px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                            Upload New Logo
                        </label>
                        <input type="file" name="logo" id="logo" class="hidden">
                        <p class="text-xs text-gray-500 mt-2">Recommended: Square PNG or JPG.</p>
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>
                </div>

                <!-- Company Info Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company Name -->
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Company Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $company->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Website URL -->
                    <div>
                        <x-input-label for="website_url" :value="__('Website URL')" />
                        <x-text-input id="website_url" name="website_url" type="url" class="mt-1 block w-full"
                            :value="old('website_url', $company->website_url)" placeholder="https://..." />
                        <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
                    </div>

                    <!-- Industry -->
                    <div>
                        <x-input-label for="industry" :value="__('Industry')" />
                        <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full"
                            :value="old('industry', $company->industry)" placeholder="e.g., Software Development" />
                        <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                    </div>

                    <!-- About Section -->
                    <div class="md:col-span-2">
                        <x-input-label for="about" :value="__('About Company')" />
                        <textarea id="about" name="about" rows="6"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('about', $company->about) }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit"
                        class="bg-teal-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-teal-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
