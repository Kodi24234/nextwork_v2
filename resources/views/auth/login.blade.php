<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- Left Side -->
        <div class="hidden md:flex w-1/2 flex-col justify-center items-center bg-teal-50 p-10">
            <img src="{{ asset('images/login-illustration.svg') }}" alt="Login Illustration" class="w-64 h-auto mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back!</h2>
            <p class="text-gray-600 text-center max-w-sm">
                Log in to connect with your network and discover new opportunities.
            </p>
        </div>

        <!-- Right Side -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-6 py-10">
            <div class="w-full max-w-md space-y-6">
                <!-- Logo -->
                <div class="text-center">
                    <a href="/" class="flex justify-center items-center space-x-2 mb-6">
                        <x-application-logo class="w-10 h-10 fill-current text-teal-600" />
                        <span class="text-2xl font-bold text-gray-800">Nextwork</span>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Sign in to your account</h2>
                    <p class="text-sm text-gray-600 mt-1">Enter your credentials below</p>
                </div>

                <!-- Status Message -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" required autofocus
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password" required
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember Me & Forgot -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500">
                            <span class="ml-2 text-gray-700">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-teal-600 hover:underline">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button class="w-full justify-center bg-teal-600 hover:bg-teal-500">
                            Log in
                        </x-primary-button>
                    </div>

                    <!-- Sign up -->
                    <p class="text-center text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="text-teal-600 font-semibold hover:underline">Sign
                            up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
