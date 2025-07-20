<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Nextwork - Your Career Starts Here</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS (Animate on Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Our TailwindCSS -->
    @vite('resources/css/app.css')

    <!-- Custom Styles for the typing cursor -->
    <style>
        .typed-cursor {
            color: #41a27d;
            /* This is teal-600 in Tailwind */
            font-weight: 700;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800">
    <div class="relative min-h-screen">
        <!-- Header/Navigation -->
        <header class="fixed inset-x-0 top-0 z-50 bg-white shadow">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8"
                aria-label="Global">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo class="text-teal-600" />
                    <span class="text-2xl font-bold text-gray-800">Nextwork</span> </a>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-semibold text-gray-800 hover:text-emerald-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-semibold text-gray-800 hover:text-emerald-600 transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-500 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>



        <!-- Hero Section -->
        <main class="relative isolate px-6 pt-14 lg:px-8">
            <div class="mx-auto max-w-3xl py-32 sm:py-48 lg:py-56">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Your Career Starts Here. <br> A Friendlier <span id="typed-strings"></span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Connect, grow, and find opportunities in a space built for you, not for the corner office.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('register') }}"
                            class="rounded-md bg-teal-600 px-5 py-3 text-base font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600 transition-transform transform hover:scale-105">Get
                            Started for Free</a>
                        <a href="#features"
                            class="text-base font-semibold leading-6 text-gray-900 hover:text-teal-600">Learn more
                            <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center" data-aos="fade-up">
                    <h2 class="text-base font-semibold leading-7 text-teal-600">Everything You Need</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">A Better Way to Network
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        We stripped away the noise to give you the tools that matter most for starting and growing your
                        career.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <!-- Feature 1 -->
                        <div class="relative pl-16" data-aos="fade-up" data-aos-delay="100">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div
                                    class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-lg bg-teal-600">
                                    <i class="fa-solid fa-user-tie text-white text-xl"></i>
                                </div>
                                Build Your Profile
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Create a professional profile that truly
                                represents you. Plus, generate a beautiful CV with one click.</dd>
                        </div>
                        <!-- Feature 2 -->
                        <div class="relative pl-16" data-aos="fade-up" data-aos-delay="200">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div
                                    class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-lg bg-teal-600">
                                    <i class="fa-solid fa-comments text-white text-xl"></i>
                                </div>
                                Make Real Connections
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Network with peers and companies. Our
                                real-time chat lets you have meaningful conversations.</dd>
                        </div>
                        <!-- Feature 3 -->
                        <div class="relative pl-16" data-aos="fade-up" data-aos-delay="300">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div
                                    class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-lg bg-teal-600">
                                    <i class="fa-solid fa-briefcase text-white text-xl"></i>
                                </div>
                                Find Your First Job
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Explore job postings from companies
                                looking for fresh talent just like you.</dd>
                        </div>
                        <!-- Feature 4 -->
                        <div class="relative pl-16" data-aos="fade-up" data-aos-delay="400">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div
                                    class="absolute left-0 top-0 flex h-12 w-12 items-center justify-center rounded-lg bg-teal-600">
                                    <i class="fa-solid fa-file-alt text-white text-xl"></i>
                                </div>
                                One-Click CV
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Turn your profile into a professional,
                                downloadable PDF resume instantly. No more formatting headaches.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
        <!-- Stats Section -->
        <section id="stats" class="py-24 bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-12 text-gray-800">Growing With You</h2>
                <div class="grid sm:grid-cols-3 gap-10">
                    <div>
                        <h3 class="text-5xl font-bold text-teal-500" data-target="32000">0</h3>
                        <p class="mt-2 text-gray-600">Users Joined</p>
                    </div>
                    <div>
                        <h3 class="text-5xl font-bold text-teal-500" data-target="1200">0</h3>
                        <p class="mt-2 text-gray-600">Job Posts</p>
                    </div>
                    <div>
                        <h3 class="text-5xl font-bold text-teal-500" data-target="7500">0</h3>
                        <p class="mt-2 text-gray-600">Connections Made</p>
                    </div>
                </div>
            </div>
        </section>




        <!-- How it works -->

        <section id="how-it-works" class="py-20 sm:py-28 bg-white">
            <div class="mx-auto max-w-7xl px-6">
                <h2 class="text-center font-display text-3xl font-bold tracking-tight text-brand-dark sm:text-4xl">Get
                    Started in 3 Easy Steps</h2>
                <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-y-16 lg:max-w-none lg:grid-cols-3 lg:gap-x-8">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-coral/10 ring-8 ring-teal-600">
                            <span class="font-display text-2xl font-bold text-brand-coral">1</span>
                        </div>
                        <h3 class="mt-6 font-display text-xl font-semibold text-brand-dark">Create Your Profile</h3>
                        <p class="mt-2 text-gray-600">Showcase your skills, projects, and personality. This is your
                            space to shine!</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-coral/10 ring-8 ring-teal-600">
                            <span class="font-display text-2xl font-bold text-brand-coral">2</span>
                        </div>
                        <h3 class="mt-6 font-display text-xl font-semibold text-brand-dark">Connect & Grow</h3>
                        <p class="mt-2 text-gray-600">Join communities, follow people who inspire you, and start real
                            conversations.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-coral/10 ring-8 ring-teal-600">
                            <span class="font-display text-2xl font-bold text-brand-coral">3</span>
                        </div>
                        <h3 class="mt-6 font-display text-xl font-semibold text-brand-dark">Find Your Opportunity</h3>
                        <p class="mt-2 text-gray-600">Explore relevant job openings and launch your career with a
                            supportive network behind you.</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Final CTA Section -->
        <section class="bg-teal-700">
            <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 text-center" data-aos="zoom-in">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Ready to build your future?</h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-teal-200">
                    Join a community of ambitious professionals and forward-thinking companies today.
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}"
                        class="rounded-md bg-white px-5 py-3 text-base font-semibold text-teal-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-transform transform hover:scale-105">Create
                        Your Account</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
                <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
                    <div class="pb-6"><a href="#"
                            class="text-sm leading-6 text-gray-400 hover:text-white">About</a></div>
                    <div class="pb-6"><a href="#"
                            class="text-sm leading-6 text-gray-400 hover:text-white">Blog</a></div>
                    <div class="pb-6"><a href="#"
                            class="text-sm leading-6 text-gray-400 hover:text-white">Careers</a></div>
                    <div class="pb-6"><a href="#"
                            class="text-sm leading-6 text-gray-400 hover:text-white">Contact</a></div>
                    <div class="pb-6"><a href="#"
                            class="text-sm leading-6 text-gray-400 hover:text-white">Privacy</a></div>
                </nav>
                <p class="mt-10 text-center text-xs leading-5 text-gray-500">© 2025 Nextwork, Inc. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- The JavaScript for interactivity -->
    <!-- Typed.js for the typing effect -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <!-- AOS (Animate on Scroll) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS (Animate on Scroll)
        AOS.init({
            duration: 800, // values from 0 to 3000, with step 50ms
            once: true, // whether animation should happen only once - while scrolling down
        });

        // Initialize Typed.js
        var typed = new Typed('#typed-strings', {
            strings: ['Professional Network.', 'Community.', 'Opportunity.'],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            startDelay: 500,
            loop: true
        });
        const counters = document.querySelectorAll('[data-target]');
        const options = {
            threshold: 0.6
        };

        const animateCounter = (entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = +el.getAttribute('data-target');
            let count = 0;
            const step = target / 60; // ~1s animation
            const update = () => {
                count += step;
                if (count < target) {
                    el.textContent = Math.floor(count).toLocaleString();
                    requestAnimationFrame(update);
                } else {
                    el.textContent = target.toLocaleString();
                }
            };
            update();
            observer.unobserve(el);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(animateCounter);
        }, options);

        counters.forEach(counter => observer.observe(counter));
    </script>
</body>

</html>
