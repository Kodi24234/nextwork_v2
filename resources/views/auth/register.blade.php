<x-guest-layout>
    <div
        class="min-h-screen bg-gradient-to-br from-cyan-800 to-teal-400 relative overflow-hidden flex items-center justify-center px-4">
        <!--  grid pattern overlay -->
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="30" height="30" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 0 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.8" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <!-- Registration  Form -->
        <div
            class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-8 sm:p-10 text-white">
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-3 mb-8 group">
                    <div class="w-10 h-10  rounded-xl mx-auto mb-3 flex items-center justify-center">
                        <x-application-logo class="w-8 h-8 text-white" />
                    </div>
                    <span
                        class="text-3xl font-bold bg-gradient-to-r from-white to-white/70 bg-clip-text text-transparent">Nextwork</span>
                </a>
                <h2 class="text-3xl font-bold text-white mb-2">Create Your Account</h2>
                <p class="text-white/80">Join us and start building your career today!</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ showPassword: false, showConfirmPassword: false }">
                @csrf

                <!-- Full Name -->
                <div>
                    <x-input-label for="name" class="text-sm font-semibold text-white mb-2">Full
                        Name</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-user text-white/70 text-sm"></i>
                        </div>
                        <x-text-input id="name" name="name" type="text" autofocus
                            class="block w-full pl-10 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                            :value="old('name')" placeholder="Enter your full name" />
                    </div>
                    @error('name')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red/70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" class="text-sm font-semibold text-white mb-2">Email
                        Address</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-email text-white/70 text-sm"></i>
                        </div>
                        <x-text-input id="email" name="email" type="email"
                            class="block w-full pl-10 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                            :value="old('email')" placeholder="Enter your email" />
                    </div>
                    @error('email')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red-70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" class="text-sm font-semibold text-white mb-2">Password</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-lock text-white/70 text-sm"></i>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            class="block w-full pl-10 pr-12 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                            placeholder="Create a strong password" />
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i :class="showPassword ? 'ti ti-eye' : 'ti ti-eye'"
                                class="text-white/70 text-sm hover:text-white"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red/70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" class="text-sm font-semibold text-white mb-2">Confirm
                        Password</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-lock text-white/70 text-sm"></i>
                        </div>
                        <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                            name="password_confirmation"
                            class="block w-full pl-10 pr-12 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:ring-white focus:border-transparent"
                            placeholder="Confirm your password" />
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i :class="showConfirmPassword ? 'ti ti-eye' : 'ti ti-eye'"
                                class="text-white/70 text-sm hover:text-white"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red/70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>



                <!-- Register -->
                <button type="submit"
                    class="w-full mt-4 bg-white/20 hover:bg-white/30 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Create Account
                </button>

                <!-- Company Link -->
                <div class="text-center mt-6 text-sm text-white/80">
                    Looking to hire? <a href="{{ route('company.register.create') }}"
                        class="text-white font-semibold hover:underline">Create a Company Page</a>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-4 text-sm text-white/80">
                    Already have an account? <a href="{{ route('login') }}"
                        class="text-white font-semibold hover:underline">Sign in</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
