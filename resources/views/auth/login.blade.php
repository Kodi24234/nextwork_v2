<x-guest-layout>
    <div
        class="min-h-screen bg-gradient-to-br from-cyan-800 to-teal-400 relative overflow-hidden flex items-center justify-center px-4">
        <!--  grid  overlay -->
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="30" height="30" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <!--  login card -->
        <div
            class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-xl p-8 sm:p-10 text-white">
            <!-- Logo -->
            <div class="mb-6 text-center">
                <div class="w-10 h-10  rounded-xl mx-auto mb-3 flex items-center justify-center">
                    <x-application-logo class="w-8 h-8 text-white" />
                </div>
                <h2 class="text-2xl font-bold">Welcome Back</h2>
                <p class="text-sm text-teal-100 mt-1">Please sign in to your account</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-semibold mb-2 block">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-email text-white/70 text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" autofocus
                            class="block w-full pl-10 pr-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent"
                            placeholder="Enter your email" value="{{ old('email') }}" />
                    </div>
                    @error('email')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red/70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="text-sm font-semibold mb-2 block">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ti ti-lock text-white/70 text-sm"></i>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            class="block w-full pl-10 pr-12 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent"
                            placeholder="Enter your password" />
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i
                                :class="showPassword
                                    ?
                                    'ti ti-eye text-white/70 text-sm hover:text-white' :
                                    'ti ti-eye text-white/70 text-sm hover:text-white'"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="mt-2 text-xs text-red-100  rounded px-2 py-1 inline-block">
                            <i class="ti ti-pencil text-red/70 text-sm me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-white/40 bg-white/10 text-white focus:ring-white w-4 h-4" />
                        <span class="ml-2 text-white/80">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-teal-100 hover:text-white transition">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg backdrop-blur-sm">
                    Sign In
                </button>

                <!-- Register -->
                <div class="text-center text-sm text-white/70 mt-4">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-white font-medium hover:underline">
                        Create account
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
