<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restaurantly - Fine Dining Experience</title>
    
    <!-- Tailwind CSS (via CDN for standalone functionality) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js (via CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Configuration for Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#f59e0b',
                            dark: '#09090b',
                            card: '#18181b',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b; 
        }
        ::-webkit-scrollbar-thumb {
            background: #3f3f46; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #52525b; 
        }
        
        /* Glass utility */
        .glass {
            background: rgba(9, 9, 11, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Modal glass */
        .modal-glass {
            background: rgba(24, 24, 27, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Input styles */
        .auth-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .auth-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        .auth-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-brand-dark text-white antialiased selection:bg-brand-gold selection:text-black" x-data="appSystem()">

    @isset($table)
    <!-- Table Banner (QR Code Scan) -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-brand-gold text-black py-2 px-4 text-center text-sm font-bold">
        <span class="flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
            Welcome to Table {{ $table->table_number }}! Your orders will be served here.
        </span>
    </div>
    @endisset

    <!-- Navigation -->
    <nav class="fixed w-full z-40 glass h-16 md:h-20 flex items-center transition-all duration-300 {{ isset($table) ? 'top-8' : 'top-0' }}" :class="{ 'shadow-lg shadow-black/50': isScrolled }" @scroll.window="isScrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0 group">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-serif font-black text-brand-gold tracking-tighter uppercase group-hover:scale-105 transition-transform duration-300">
                    Restaurantly
                </h1>
            </a>
            
            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-x-6 lg:gap-x-10">
                <a href="#hero" class="text-sm font-medium text-white/70 hover:text-brand-gold transition-colors py-2 relative group">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-gold transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#menu" class="text-sm font-medium text-white/70 hover:text-brand-gold transition-colors py-2 relative group">
                    Menu
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-gold transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#about" class="text-sm font-medium text-white/70 hover:text-brand-gold transition-colors py-2 relative group">
                    About
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-gold transition-all duration-300 group-hover:w-full"></span>
                </a>
                
                @auth
                    <!-- Logged in: Show Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-4 text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white transition-colors border-l border-white/10 pl-6 lg:pl-8">
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Guest: Show Login/Register -->
                    <button @click="showLoginModal = true" class="text-sm font-medium text-white/70 hover:text-brand-gold transition-colors py-2">
                        Login
                    </button>
                    <button @click="showRegisterModal = true" class="bg-brand-gold text-black font-bold py-2 px-4 lg:px-6 rounded-full hover:bg-white transition-all duration-300 text-xs uppercase tracking-widest">
                        Register
                    </button>
                @endauth
            </div>

            <!-- Mobile Menu Button & Cart -->
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Cart Button -->
                <button @click="isCartOpen = !isCartOpen" class="relative group p-2 md:p-3 rounded-full hover:bg-white/5 transition-all duration-300">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white group-hover:text-brand-gold transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="cart.length > 0" 
                          x-transition:enter="transition ease-out duration-300"
                          x-transition:enter-start="scale-0 opacity-0"
                          x-transition:enter-end="scale-100 opacity-100"
                          x-text="cart.length" 
                          class="absolute -top-1 -right-1 bg-brand-gold text-black text-[10px] font-black px-1.5 py-0.5 rounded-full shadow-lg shadow-brand-gold/40">
                    </span>
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-white/5 transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.away="mobileMenuOpen = false"
             class="absolute top-full left-0 right-0 glass md:hidden">
            <div class="px-4 py-4 space-y-3">
                <a href="#hero" @click="mobileMenuOpen = false" class="block py-2 text-white/70 hover:text-brand-gold transition-colors">Home</a>
                <a href="#menu" @click="mobileMenuOpen = false" class="block py-2 text-white/70 hover:text-brand-gold transition-colors">Menu</a>
                <a href="#about" @click="mobileMenuOpen = false" class="block py-2 text-white/70 hover:text-brand-gold transition-colors">About</a>
                
                <div class="border-t border-white/10 pt-3 mt-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-white/70 hover:text-brand-gold transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <button @click="showLoginModal = true; mobileMenuOpen = false" class="block w-full text-left py-2 text-white/70 hover:text-brand-gold transition-colors">
                            Login
                        </button>
                        <button @click="showRegisterModal = true; mobileMenuOpen = false" class="block w-full text-left py-2 text-brand-gold font-semibold">
                            Register
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/food/hero.png') }}" alt="Restaurant Interior" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/40 to-transparent"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
            <div class="max-w-3xl animate-fade-in-up">
                <!-- Badge -->
                <div class="mb-6 md:mb-8 flex items-center gap-4">
                    <span class="h-[1px] w-8 md:w-12 bg-brand-gold"></span>
                    <span class="inline-block text-brand-gold font-bold tracking-[0.2em] md:tracking-[0.3em] uppercase text-[10px] md:text-xs">
                        Est. 2024
                    </span>
                </div>
                
                <!-- Headline -->
                <h2 class="text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-serif font-black text-white leading-[0.95] tracking-tight mb-6 md:mb-8">
                    Taste the <br> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-gold to-yellow-200 italic pr-2">Unforgettable</span>
                </h2>
                
                <!-- Subtext -->
                <p class="text-gray-400 text-base md:text-lg lg:text-xl max-w-xl leading-relaxed mb-8 md:mb-12 font-light border-l-2 border-brand-gold/30 pl-4 md:pl-6">
                    Experience the symphony of flavors. We blend tradition with modern culinary art to create memories on a plate.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
                    <a href="#menu" class="text-center bg-brand-gold text-black font-bold py-3 md:py-4 px-8 md:px-10 rounded-full hover:bg-white transition-all duration-300 hover:shadow-[0_0_20px_rgba(245,158,11,0.4)] transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                        View Full Menu
                    </a>
                    <a href="#about" class="text-center px-8 md:px-10 py-3 md:py-4 rounded-full border border-white/20 hover:border-white hover:bg-white/5 text-white font-bold transition-all duration-300 uppercase tracking-widest text-xs backdrop-blur-sm">
                        Read Our Story
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-white/30 hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-16 md:py-32 bg-brand-dark relative">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-20">
                <span class="text-brand-gold font-bold tracking-[0.3em] md:tracking-[0.4em] uppercase text-[10px] mb-4 block">
                    Culinary Excellence
                </span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-serif font-black mb-6 uppercase tracking-tight">
                    Chef's Selection
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-brand-gold to-transparent mx-auto"></div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($data as $food)
                <div class="group bg-brand-card rounded-2xl overflow-hidden border border-white/5 hover:border-brand-gold/30 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-gold/10 flex flex-col h-full">
                    <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden">
                        @php
                            $img = 'assets/images/food/steak.png';
                            if(str_contains(strtolower($food->name_en), 'pasta')) $img = 'assets/images/food/pasta.png';
                        @endphp
                        <img src="{{ asset($img) }}" alt="{{ $food->name_en }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors duration-300"></div>
                        <div class="absolute top-4 right-4 bg-black/70 backdrop-blur-sm px-3 md:px-4 py-1 md:py-1.5 rounded-full border border-white/10">
                            <span class="text-brand-gold font-bold text-sm">${{ number_format($food->price, 2) }}</span>
                        </div>
                    </div>
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                        <div class="mb-auto">
                            <span class="text-[10px] uppercase tracking-[0.2em] text-white/40 font-bold mb-2 block">
                                {{ $food->sub_category->name_en ?? 'Specialty' }}
                            </span>
                            <h3 class="text-xl md:text-2xl font-serif font-bold mb-3 group-hover:text-brand-gold transition-colors">{{ $food->name_en }}</h3>
                            <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
                                Experience the rich textures and bold aromas of this carefully prepared dish.
                            </p>
                        </div>
                        <button @click="addToCart({ id: {{ $food->id }}, name: '{{ $food->name_en }}', price: {{ $food->price }} })" class="mt-6 w-full bg-white/5 hover:bg-brand-gold hover:text-black text-white font-bold py-3 rounded-xl border border-white/10 hover:border-brand-gold transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 group/btn">
                            <span class="group-hover/btn:rotate-90 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </span>
                            Add to Order
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 md:py-32 bg-zinc-950 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="text-brand-gold font-bold tracking-[0.3em] uppercase text-[10px] mb-4 block">
                        Our Story
                    </span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif font-black mb-6">
                        A Passion for <span class="text-brand-gold italic">Excellence</span>
                    </h2>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Founded in 2024, Restaurantly was born from a simple belief: that great food brings people together. Our chefs combine traditional techniques with innovative approaches to create dishes that tell a story.
                    </p>
                    <p class="text-gray-400 leading-relaxed mb-8">
                        Every ingredient is carefully sourced, every dish meticulously crafted. We invite you to experience the warmth of our hospitality and the artistry of our cuisine.
                    </p>
                    <div class="flex flex-wrap gap-8">
                        <div>
                            <span class="text-4xl font-serif font-black text-brand-gold">15+</span>
                            <p class="text-gray-500 text-sm mt-1">Expert Chefs</p>
                        </div>
                        <div>
                            <span class="text-4xl font-serif font-black text-brand-gold">50+</span>
                            <p class="text-gray-500 text-sm mt-1">Menu Items</p>
                        </div>
                        <div>
                            <span class="text-4xl font-serif font-black text-brand-gold">1000+</span>
                            <p class="text-gray-500 text-sm mt-1">Happy Guests</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-square rounded-2xl overflow-hidden">
                        <img src="{{ asset('assets/images/food/hero.png') }}" alt="Our Restaurant" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-brand-gold text-black p-6 rounded-2xl hidden md:block">
                        <p class="font-serif font-bold text-lg">Open Daily</p>
                        <p class="text-sm">11:00 AM - 11:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-8 md:py-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-xl md:text-2xl font-serif font-bold text-white mb-4">Restaurantly</h2>
            <p class="text-gray-500 text-sm">© 2026 Restaurantly. All rights reserved.</p>
        </div>
    </footer>

    <!-- Login Modal -->
    <div x-show="showLoginModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[70] flex items-center justify-center p-4"
         style="display: none;">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showLoginModal = false"></div>
        
        <!-- Modal Content -->
        <div x-show="showLoginModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative modal-glass rounded-2xl p-6 md:p-8 w-full max-w-md border border-white/10 shadow-2xl">
            
            <!-- Close Button -->
            <button @click="showLoginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header -->
            <div class="text-center mb-8">
                <h3 class="text-2xl font-serif font-bold text-brand-gold mb-2">Welcome Back</h3>
                <p class="text-gray-400 text-sm">Sign in to continue your order</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <input type="password" name="password" placeholder="Password" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

               

                <button type="submit" class="w-full bg-brand-gold text-black font-bold py-3 rounded-xl hover:bg-yellow-400 transition-all duration-300 uppercase tracking-widest text-xs">
                    Sign In
                </button>
            </form>

            <!-- Switch to Register -->
            <div class="text-center mt-6 pt-6 border-t border-white/10">
                <p class="text-gray-400 text-sm">
                    Don't have an account? 
                    <button @click="showLoginModal = false; showRegisterModal = true" class="text-brand-gold hover:underline font-semibold">
                        Create one
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegisterModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[70] flex items-center justify-center p-4"
         style="display: none;">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="showRegisterModal = false"></div>
        
        <!-- Modal Content -->
        <div x-show="showRegisterModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative modal-glass rounded-2xl p-6 md:p-8 w-full max-w-md border border-white/10 shadow-2xl max-h-[90vh] overflow-y-auto">
            
            <!-- Close Button -->
            <button @click="showRegisterModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header -->
            <div class="text-center mb-8">
                <h3 class="text-2xl font-serif font-bold text-brand-gold mb-2">Join Us</h3>
                <p class="text-gray-400 text-sm">Create an account to start ordering</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <input type="password" name="password" placeholder="Password" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                           class="auth-input w-full px-4 py-3 rounded-xl text-white outline-none">
                </div>

                <button type="submit" class="w-full bg-brand-gold text-black font-bold py-3 rounded-xl hover:bg-yellow-400 transition-all duration-300 uppercase tracking-widest text-xs">
                    Create Account
                </button>
            </form>

            <!-- Switch to Login -->
            <div class="text-center mt-6 pt-6 border-t border-white/10">
                <p class="text-gray-400 text-sm">
                    Already have an account? 
                    <button @click="showRegisterModal = false; showLoginModal = true" class="text-brand-gold hover:underline font-semibold">
                        Sign in
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Cart Drawer Backdrop -->
    <div x-show="isCartOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isCartOpen = false" 
         class="fixed inset-0 bg-black/80 z-[50] backdrop-blur-sm"></div>

    <!-- Side Cart Drawer -->
    <div x-show="isCartOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-full max-w-sm md:max-w-md bg-zinc-900 z-[60] shadow-2xl border-l border-white/10 flex flex-col">
        
        <!-- Drawer Header -->
        <div class="flex justify-between items-center p-6 md:p-8 border-b border-white/5 bg-zinc-900">
            <div>
                <h2 class="text-xl md:text-2xl font-serif font-bold text-white">Your Order</h2>
                <p class="text-xs text-gray-500 mt-1" x-show="cart.length > 0">Items in tray: <span x-text="cart.length"></span></p>
            </div>
            <button @click="isCartOpen = false" class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-white/5 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Drawer Body (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4">
            <template x-for="(item, index) in cart" :key="index">
                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/5 hover:border-white/10 transition-colors group/item">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-zinc-800 flex items-center justify-center text-brand-gold font-serif font-bold text-lg flex-shrink-0">
                        <span x-text="item.name.charAt(0)"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 x-text="item.name" class="font-bold text-white text-sm truncate"></h4>
                        <div class="flex items-center justify-between mt-1">
                            <span x-text="'$' + item.price.toFixed(2)" class="text-brand-gold font-bold text-sm"></span>
                            <button @click="removeFromCart(index)" class="text-xs text-gray-500 hover:text-red-400 transition-colors">Remove</button>
                        </div>
                    </div>
                </div>
            </template>
            
            <!-- Empty State -->
            <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-full text-center py-10 opacity-50">
                <svg class="w-16 h-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <p class="text-gray-300 font-serif italic text-lg">Your tray is empty.</p>
                <p class="text-gray-500 text-sm mt-2">Add some delicious items to start.</p>
            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="p-6 md:p-8 border-t border-white/5 bg-zinc-900">
            <div class="flex justify-between items-center mb-6">
                <span class="text-gray-400 uppercase tracking-widest text-xs font-bold">Total</span>
                <span class="text-2xl md:text-3xl font-serif font-black text-brand-gold" x-text="'$' + total.toFixed(2)"></span>
            </div>
            <button @click="checkout" 
                    class="w-full bg-brand-gold hover:bg-yellow-400 text-black font-bold py-3 md:py-4 rounded-xl transition-all shadow-lg shadow-brand-gold/20 hover:shadow-brand-gold/40 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 group text-sm md:text-base" 
                    :disabled="cart.length === 0">
                <span>Confirm Order</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Logic -->
    <script>
        function appSystem() {
            return {
                cart: [],
                isCartOpen: false,
                isScrolled: false,
                mobileMenuOpen: false,
                showLoginModal: false,
                showRegisterModal: false,
                isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
                tableId: {{ isset($table) ? $table->id : 'null' }},
                
                get total() {
                    return this.cart.reduce((sum, item) => sum + item.price, 0);
                },
                
                addToCart(item) {
                    this.cart.push(item);
                },
                
                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },
                
                checkout() {
                    if (this.cart.length === 0) return;
                    
                    // Check if user is authenticated
                    if (!this.isAuthenticated) {
                        this.isCartOpen = false;
                        this.showLoginModal = true;
                        return;
                    }
                    
                    const foodIds = this.cart.map(i => i.id);
                    const orderData = { 
                        food_items: foodIds,
                        table_id: this.tableId
                    };
                    
                    fetch('{{ route("orders.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(orderData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const tableMsg = this.tableId ? ' Your food will be served at your table.' : '';
                            alert('Order confirmed! Thank you for your order.' + tableMsg);
                            this.cart = [];
                            this.isCartOpen = false;
                        } else {
                            alert('Session expired or error occurred. Please login again.');
                            this.showLoginModal = true;
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        alert('Connection failed. Please check your connection and try again.');
                    });
                }
            }
        }
    </script>

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are login or register errors and show appropriate modal
            @if($errors->has('email') || $errors->has('password'))
                document.querySelector('[x-data]').__x.$data.showLoginModal = true;
            @endif
            @if($errors->has('name'))
                document.querySelector('[x-data]').__x.$data.showRegisterModal = true;
            @endif
        });
    </script>
    @endif
</body>
</html>
