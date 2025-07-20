<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Side (Form) -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-8">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <a href="/" class="flex justify-center items-center space-x-2 mb-4">
                        <x-application-logo class="w-10 h-10 fill-current text-teal-600" />
                        <span class="text-2xl font-bold text-teal-700">Nextwork</span>
                    </a>
                    {{-- MODIFIED TEXT FOR COMPANIES --}}
                    <h2 class="text-3xl font-bold text-teal-800">Create a Company Page</h2>
                    <p class="text-sm text-teal-600 mt-1">Start posting jobs and finding talent.</p>
                </div>

                {{-- The form now points to the new company registration route --}}
                <form method="POST" action="{{ route('company.register.store') }}">
                    @csrf

                    <!-- Company Name -->
                    <div>
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name"
                            class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500" type="text"
                            name="company_name" :value="old('company_name')" required autofocus />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <!-- User's Full Name -->
                    <div class="mt-4">
                        <x-input-label for="user_name" :value="__('Your Full Name')" />
                        <x-text-input id="user_name" class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500"
                            type="text" name="user_name" :value="old('user_name')" required />
                        <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Your Work Email')" />
                        <x-text-input id="email" class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500"
                            type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password fields are the same -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500"
                            type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation"
                            class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500" type="password"
                            name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center bg-teal-600 hover:bg-teal-500">
                            {{ __('Create Company Page') }}
                        </x-primary-button>
                    </div>

                    <!-- Link back to Professional Registration -->
                    <div class="my-6 flex items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-4 text-gray-500 text-sm">or</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('register') }}"
                            class="w-full inline-block text-center px-4 py-2 border border-teal-600 text-teal-700 font-semibold rounded-lg hover:bg-teal-50 transition">
                            Join as a Professional
                        </a>
                    </div>

                </form>
            </div>
        </div>


        <!-- Right Side (Illustration) -->
        <div class="hidden md:flex md:w-1/2 bg-teal-50 items-center justify-center p-12">
            <div class="max-w-md text-center">
                <img src="{{ asset('images/login-illustration.svg') }}" alt="Register Illustration"
                    class="mx-auto w-64 h-auto">
                <h2 class="mt-8 text-2xl font-bold text-teal-800">Join Our Network!</h2>
                <p class="mt-2 text-teal-600">Create an account to start building your profile and making connections.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
