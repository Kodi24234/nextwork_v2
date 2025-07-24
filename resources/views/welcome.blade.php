<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nextwork - Your Career Starts Here</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS (Animate on Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['figtree', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        'brand': {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .hero-gradient {
            background: linear-gradient(135deg, #14b8a6 0%, #0891b2 50%, #7c3aed 100%);
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .pulse-glow {
            box-shadow: 0 0 0 0 rgba(20, 184, 166, 0.7);
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(20, 184, 166, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(20, 184, 166, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(20, 184, 166, 0);
            }
        }

        .typed-cursor {
            color: #14b8a6;
            font-weight: 700;
        }

        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800 overflow-x-hidden">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-brand-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse">
        </div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"
            style="animation-delay: 4s;"></div>
    </div>

    <div class="relative min-h-screen z-10">
        <!-- Enhanced Header/Navigation -->
        <header class="fixed inset-x-0 top-0 z-50 glass-effect backdrop-blur-md">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8"
                aria-label="Global">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 from-brand-500 to-blue-600 rounded-xl flex items-center justify-center ">
                        <x-application-logo class="w-8 h-8 text-white" />
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-brand-600 to-blue-600 bg-clip-text text-transparent">Nextwork</span>
                </a>

                <!-- Navigation Links (Hidden on mobile, visible on larger screens) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">Features</a>
                    <a href="#how-it-works"
                        class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">How it
                        Works</a>
                    <a href="#stats"
                        class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">About</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <a href="/login"
                        class="text-sm font-semibold text-gray-700 hover:text-brand-600 transition-colors">Log in</a>
                    <a href="/register"
                        class="rounded-xl bg-gradient-to-r from-brand-600 to-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                        Get Started
                    </a>
                </div>
            </nav>
        </header>

        <!-- Enhanced Hero Section -->
        <main class="relative px-6 pt-14 lg:px-8">
            <div class="mx-auto max-w-4xl py-32 sm:py-48 lg:py-56">
                <div class="text-center">
                    <!-- Hero Badge -->
                    <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-brand-50 to-blue-50 px-4 py-2 text-sm font-medium text-brand-700 ring-1 ring-brand-200 mb-8"
                        data-aos="fade-down">
                        <i class="fas fa-rocket text-brand-500"></i>
                        <span>Launch Your Career Journey</span>
                    </div>

                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8" data-aos="fade-up"
                        data-aos-delay="100">
                        Your Career Starts <br>
                        <span
                            class="bg-gradient-to-r from-brand-600 via-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Here
                        </span>
                    </h1>

                    <div class="text-2xl md:text-3xl font-bold text-gray-700 mb-8" data-aos="fade-up"
                        data-aos-delay="200">
                        A Friendlier <span id="typed-strings" class="text-brand-600"></span>
                    </div>

                    <p class="mt-6 text-xl leading-8 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up"
                        data-aos-delay="300">
                        Connect, grow, and find opportunities in a space built for you, not for the corner office. Join
                        thousands of professionals building their future.
                    </p>

                    <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-6" data-aos="fade-up"
                        data-aos-delay="400">
                        <a href="/register"
                            class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-2xl transition-all hover:scale-105 hover:shadow-3xl pulse-glow">
                            <span class="relative z-10 flex items-center gap-2">
                                <i class="fas fa-rocket"></i>
                                Get Started for Free
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </a>

                        <a href="#features"
                            class="group flex items-center gap-2 text-lg font-semibold text-gray-700 hover:text-brand-600 transition-colors">
                            <span>Learn more</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>


                </div>
            </div>
        </main>

        <!-- Enhanced Features Section -->
        <section id="features" class="py-24 bg-white relative">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center" data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-4 py-2 text-sm font-medium text-brand-700 mb-4">
                        <i class="fas fa-star text-brand-500"></i>
                        <span>Everything You Need</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900 mb-6">
                        A Better Way to <span class="text-brand-600">Network</span>
                    </h2>
                    <p class="text-xl leading-8 text-gray-600">
                        We stripped away the noise to give you the tools that matter most for starting and growing your
                        career.
                    </p>
                </div>

                <div class="mx-auto mt-20 max-w-6xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Feature 1 -->
                        <div class="feature-card group relative bg-gradient-to-br from-white to-brand-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl border border-brand-100"
                            data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <i class="fas fa-user-tie text-white text-2xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">Build Your Profile</h3>
                                    <p class="text-gray-600 leading-relaxed">Create a professional profile that truly
                                        represents you. Plus, generate a beautiful CV with one click.</p>
                                    <div class="mt-4 flex items-center gap-2 text-brand-600 font-medium">
                                        <span>Get started</span>
                                        <i
                                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="feature-card group relative bg-gradient-to-br from-white to-blue-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl border border-blue-100"
                            data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <i class="fas fa-comments text-white text-2xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">Make Real Connections</h3>
                                    <p class="text-gray-600 leading-relaxed">Network with peers and companies. Our
                                        real-time chat lets you have meaningful conversations.</p>
                                    <div class="mt-4 flex items-center gap-2 text-blue-600 font-medium">
                                        <span>Start connecting</span>
                                        <i
                                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="feature-card group relative bg-gradient-to-br from-white to-purple-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl border border-purple-100"
                            data-aos="fade-up" data-aos-delay="300">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <i class="fas fa-briefcase text-white text-2xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">Find Your First Job</h3>
                                    <p class="text-gray-600 leading-relaxed">Explore job postings from companies
                                        looking for fresh talent just like you.</p>
                                    <div class="mt-4 flex items-center gap-2 text-purple-600 font-medium">
                                        <span>Browse jobs</span>
                                        <i
                                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div class="feature-card group relative bg-gradient-to-br from-white to-orange-50 rounded-3xl p-8 shadow-lg hover:shadow-2xl border border-orange-100"
                            data-aos="fade-up" data-aos-delay="400">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <i class="fas fa-file-alt text-white text-2xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">One-Click CV</h3>
                                    <p class="text-gray-600 leading-relaxed">Turn your profile into a professional,
                                        downloadable PDF resume instantly. No more formatting headaches.</p>
                                    <div class="mt-4 flex items-center gap-2 text-orange-600 font-medium">
                                        <span>Generate CV</span>
                                        <i
                                            class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Stats Section -->
        <section id="stats" class="py-24 bg-gradient-to-br from-gray-50 to-brand-50 relative">
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            <div class="max-w-6xl mx-auto px-6 text-center relative">
                <div data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-medium text-brand-700 mb-4 shadow-sm">
                        <i class="fas fa-chart-line text-brand-500"></i>
                        <span>Growing Community</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Growing With <span
                            class="text-brand-600">You</span></h2>
                    <p class="text-xl text-gray-600 mb-16 max-w-2xl mx-auto">Join thousands of professionals who are
                        already building their future with Nextwork.</p>
                </div>

                <div class="grid sm:grid-cols-3 gap-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border border-gray-100">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <h3 class="text-5xl font-bold text-brand-600 mb-2 counter"
                                data-target="{{ $userCount }}">0
                            </h3>
                            <p class="text-gray-600 font-medium">Users Joined</p>
                        </div>
                    </div>
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border border-gray-100">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-briefcase text-white text-2xl"></i>
                            </div>
                            <h3 class="text-5xl font-bold text-blue-600 mb-2 counter"
                                data-target="{{ $jobCount }}">
                                0</h3>
                            <p class="text-gray-600 font-medium">Job Posts</p>
                        </div>
                    </div>
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border border-gray-100">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-handshake text-white text-2xl"></i>
                            </div>
                            <h3 class="text-5xl font-bold text-purple-600 mb-2 counter"
                                data-target="{{ $connectionCount }}">0</h3>
                            <p class="text-gray-600 font-medium">Connections Made</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced How it Works Section -->
        <section id="how-it-works" class="py-24 bg-white relative">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center mb-20" data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-4 py-2 text-sm font-medium text-brand-700 mb-4">
                        <i class="fas fa-route text-brand-500"></i>
                        <span>Your Journey</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900 mb-6">
                        Get Started in <span class="text-brand-600">3 Easy Steps</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Your professional journey starts here. Follow these simple steps to unlock your potential.
                    </p>
                </div>

                <div class="grid max-w-5xl mx-auto grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Step 1 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                        <div class="relative mb-8">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-brand-500 to-brand-600 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:scale-110 transition-transform floating">
                                <span class="text-3xl font-bold text-white">1</span>
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-ping">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Create Your Profile</h3>
                        <p class="text-gray-600 leading-relaxed">Showcase your skills, projects, and personality. This
                            is your space to shine and make a lasting first impression!</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                        <div class="relative mb-8">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:scale-110 transition-transform floating"
                                style="animation-delay: 1s;">
                                <span class="text-3xl font-bold text-white">2</span>
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full animate-ping"
                                style="animation-delay: 0.5s;"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Connect & Grow</h3>
                        <p class="text-gray-600 leading-relaxed">Join communities, follow people who inspire you, and
                            start real conversations that lead to opportunities.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                        <div class="relative mb-8">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:scale-110 transition-transform floating"
                                style="animation-delay: 2s;">
                                <span class="text-3xl font-bold text-white">3</span>
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-400 rounded-full animate-ping"
                                style="animation-delay: 1s;"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Find Your Opportunity</h3>
                        <p class="text-gray-600 leading-relaxed">Explore relevant job openings and launch your career
                            with a supportive network behind you every step of the way.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Final CTA Section -->
        <section class="relative bg-gradient-to-br from-brand-600 via-blue-600 to-purple-700 overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-20 w-32 h-32 bg-white rounded-full opacity-10 animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-24 h-24 bg-white rounded-full opacity-10 animate-pulse"
                    style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-white rounded-full opacity-5 animate-pulse"
                    style="animation-delay: 2s;"></div>
            </div>

            <div class="relative mx-auto max-w-4xl px-6 py-24 sm:py-32 lg:px-8 text-center" data-aos="zoom-in">
                <div class="mb-8">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white bg-opacity-20 px-4 py-2 text-sm font-medium text-white mb-6 backdrop-blur-sm">
                        <i class="fas fa-rocket text-white"></i>
                        <span>Ready to Launch?</span>
                    </div>
                </div>

                <h2 class="text-4xl md:text-6xl font-bold tracking-tight text-white mb-8">
                    Ready to build your <span class="text-yellow-300">future?</span>
                </h2>

                <p class="mx-auto max-w-2xl text-xl leading-8 text-white text-opacity-90 mb-12">
                    Join a community of ambitious professionals and forward-thinking companies today. Your next
                    opportunity is just one connection away.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="/register"
                        class="group relative overflow-hidden rounded-2xl bg-white px-8 py-4 text-lg font-bold text-brand-600 shadow-2xl hover:shadow-3xl transition-all hover:scale-105">
                        <span class="relative z-10 flex items-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            Create Your Account
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-yellow-200 to-yellow-300 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                    </a>

                    <div class="flex items-center gap-4 text-white text-opacity-90">

                        <span class="text-sm">
                            Join <strong>{{ $userCount }} + </strong> professionals
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 mt-20">
            <div
                class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                <p class="text-gray-500 text-sm">&copy; 2025 Nextwork. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-brand-600 text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-brand-600 text-sm">Terms of Service</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- AOS (Animate on Scroll) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Typed.js for Hero Text Animation -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        new Typed('#typed-strings', {
            strings: ['Experience.', 'Networking.', 'Growth.'],
            typeSpeed: 80,
            backSpeed: 50,
            backDelay: 2000,
            loop: true
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.dataset.target;
                const duration = 2000;
                const stepTime = Math.max(Math.floor(duration / target), 10);
                let count = 0;

                const updateCount = () => {
                    count += Math.ceil(target / (duration / stepTime));
                    if (count >= target) {
                        counter.textContent = target.toLocaleString();
                    } else {
                        counter.textContent = count.toLocaleString();
                        setTimeout(updateCount, stepTime);
                    }
                };

                updateCount();
            });
        });
    </script>

</body>

</html>
