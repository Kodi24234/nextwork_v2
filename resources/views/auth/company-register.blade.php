<x-guest-layout>
    <div
        class="min-h-screen bg-gradient-to-br from-cyan-800 to-teal-400 relative overflow-hidden flex items-center justify-center px-4">
        <!--  grid overlay -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="30" height="30" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <!-- Form container  -->
        <div
            class="relative z-10 w-full max-w-xl bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-8 sm:p-10 text-white">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-3 mb-6 group">
                    <div class="w-10 h-10  rounded-xl mx-auto mb-3 flex items-center justify-center">
                        <x-application-logo class="w-8 h-8 text-white" />
                    </div>
                    <span
                        class="text-3xl text-white font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                        Nextwork for Companies
                    </span>
                </a>
                <h2 class="text-2xl font-bold text-white">Create Your Company Page</h2>
                <p class="text-sm text-white/70">Start hiring top talent effortlessly.</p>
            </div>

            <!-- Company Registration Form -->
            <form method="POST" action="{{ route('company.register.store') }}" class="space-y-4"
                x-data="{ showPassword: false, showConfirmPassword: false }">
                @csrf

                <!-- Company Name -->
                <div>
                    <x-input-label for="company_name" class="text-sm font-semibold text-white mb-2">Company
                        Name</x-input-label>
                    <x-text-input id="company_name" name="company_name" type="text"
                        class="block w-full pl-4 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                        :value="old('company_name')" placeholder="Enter your company name" />
                    @error('company_name')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-alert text-red/70 text-sm"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Full Name -->
                <div>
                    <x-input-label for="user_name" class="text-sm text-white font-semibold">Your Full
                        Name</x-input-label>
                    <x-text-input id="user_name" name="user_name" type="text"
                        class="block w-full pl-4 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                        :value="old('user_name')" placeholder="Enter your full name" />
                    @error('user_name')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-alert text-red/70 text-sm"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" class="text-sm text-white font-semibold">Work Email</x-input-label>
                    <x-text-input id="email" name="email" type="email"
                        class="block w-full pl-4 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                        :value="old('email')" placeholder="Enter work email" />
                    @error('email')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-alert text-red/70 text-sm"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input-label for="password" class="text-sm text-white font-semibold">Password</x-input-label>
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                        class="block w-full pl-4 pr-12 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                        placeholder="Create a password" />
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 top-5 pr-4 flex items-center">
                        <i :class="showPassword ? 'ti ti-eye' : 'ti ti-eye'"
                            class="text-white/70 text-sm hover:text-white"></i>
                    </button>
                    @error('password')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-alert text-red/70 text-sm"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <x-input-label for="password_confirmation" class="text-sm text-white font-semibold">Confirm
                        Password</x-input-label>
                    <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                        name="password_confirmation"
                        class="block w-full pl-4 pr-12 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                        placeholder="Repeat password" />
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 top-5 pr-4 flex items-center">
                        <i :class="showPassword ? 'ti ti-eye' : 'ti ti-eye'"
                            class="text-white/70 text-sm hover:text-white"></i>
                    </button>
                    @error('password_confirmation')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-alert text-red/70 text-sm"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="w-full mt-4 bg-white/20 hover:bg-white/30 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Create Company Page
                    </button>
                </div>

                <!-- Join as Professional -->
                <div class="text-center pt-6 text-sm text-white/80">
                    Want to connect instead?
                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline">
                        Join as a Professional
                    </a>
                </div>
            </form>
        </div>


    </div>
</x-guest-layout>
