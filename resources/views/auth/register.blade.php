<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Left Side (Form) -->
        <div class="w-full md:w-1/2 flex flex-col justify-center bg-white py-12 px-6 sm:px-10 md:px-16 lg:px-24">

            <div class="w-full max-w-md mx-auto">
                <div class="text-center mb-6">
                    <a href="/" class="flex justify-center items-center space-x-2 mb-4">
                        <x-application-logo class="w-10 h-10 fill-current text-teal-600" />
                        <span class="text-2xl font-bold text-teal-700">Nextwork</span>
                    </a>
                    <h2 class="text-3xl font-bold text-teal-800">Create a Professional Profile</h2>
                    <p class="text-sm text-teal-600 mt-1">Showcase your skills and find your next opportunity.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500"
                            type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full focus:ring-teal-500 focus:border-teal-500"
                            type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

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

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center bg-teal-600 hover:bg-teal-500">
                            {{ __('Agree & Join') }}
                        </x-primary-button>
                    </div>

                    <div class="my-6 flex items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-4 text-gray-500 text-sm">or</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('company.register.create') }}"
                            class="w-full inline-block text-center px-4 py-2 border border-teal-600 text-teal-700 font-semibold rounded-lg hover:bg-teal-50 transition">
                            Hiring? Create a Company Page
                        </a>
                    </div>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Already on Nextwork?
                        <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:underline">Sign in</a>
                    </p>
                </form>
            </div>
        </div>

        <!-- Right Side (Illustration) -->
        <div class="hidden md:flex w-1/2 bg-teal-50 flex items-center justify-center p-8 sm:p-12">
            <div class="max-w-md text-center">
                <img src="{{ asset('images/login-illustration.svg') }}" alt="Register Illustration"
                    class="mx-auto w-60 md:w-64 h-auto">
                <h2 class="mt-8 text-2xl font-bold text-teal-800">Join Our Network!</h2>
                <p class="mt-2 text-teal-600">Create an account to start building your profile and making connections.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
