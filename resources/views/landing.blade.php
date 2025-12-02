<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Absensi Mahasiswa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #60A5FA 0%, #A78BFA 50%, #F472B6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out;
        }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob bg-blue-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-purple-600 w-[30rem] h-[30rem] rounded-full bottom-0 right-0 translate-x-1/3 translate-y-1/3 animation-delay-2000"></div>
        <div class="blob bg-pink-600 w-80 h-80 rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-30 animation-delay-4000"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="text-2xl font-bold tracking-tighter">
                        <span class="text-blue-400">Absensi</span><span class="text-white">Mahasiswa</span>
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="{{ url('/') }}" class="hover:text-blue-400 transition-colors px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors px-3 py-2 rounded-md text-sm font-medium">Tentang</a>
                        @auth
                            <a href="{{ url('/home') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-2 rounded-full text-sm font-medium transition-all hover:scale-105 backdrop-blur-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-2 rounded-full text-sm font-medium transition-all hover:scale-105 backdrop-blur-sm">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    @auth
                        <a href="{{ url('/home') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-500/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-purple-500/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-500/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-6 py-3 rounded-full glass mb-8 animate-fade-in-up hover:bg-white/10 transition-all cursor-default border border-white/20 shadow-lg shadow-blue-500/10">
                <span class="relative flex h-3 w-3 mr-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-gray-200 tracking-wide">Sistem Absensi Modern Terintegrasi</span>
            </div>
            
            <h1 class="text-6xl md:text-8xl font-bold mb-8 tracking-tight leading-tight drop-shadow-2xl">
                Kelola Kehadiran <br>
                <span class="gradient-text" id="typed-output"></span>
            </h1>
            
            <p class="mt-6 max-w-3xl mx-auto text-xl md:text-2xl text-gray-300 mb-12 leading-relaxed font-light">
                Platform absensi digital yang memudahkan mahasiswa dan dosen dalam mencatat kehadiran secara <span class="text-white font-semibold">realtime</span>, <span class="text-white font-semibold">akurat</span>, dan <span class="text-white font-semibold">transparan</span>.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                @auth
                    <a href="{{ url('/home') }}" class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full text-white font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:-translate-y-1 hover:scale-105 overflow-hidden ring-2 ring-white/20">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                        <span class="relative flex items-center gap-3 text-lg">
                            Ke Dashboard
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full text-white font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:-translate-y-1 hover:scale-105 overflow-hidden ring-2 ring-white/20">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                        <span class="relative flex items-center gap-3 text-lg">
                            Mulai Sekarang
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                    </a>
                @endauth
                <a href="#features" class="px-8 py-4 rounded-full glass text-white font-semibold hover:bg-white/10 transition-all hover:-translate-y-1 hover:scale-105 border border-white/10 flex items-center gap-2">
                    <span>Pelajari Lebih Lanjut</span>
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto border-t border-white/10 pt-12 bg-white/5 rounded-3xl p-8 backdrop-blur-sm">
                <div class="text-center group hover:transform hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300 mb-2">100%</div>
                    <div class="text-sm text-gray-300 font-medium uppercase tracking-wider">Digital</div>
                </div>
                <div class="text-center group hover:transform hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-300 mb-2">24/7</div>
                    <div class="text-sm text-gray-300 font-medium uppercase tracking-wider">Akses</div>
                </div>
                <div class="text-center group hover:transform hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300 mb-2">Realtime</div>
                    <div class="text-sm text-gray-300 font-medium uppercase tracking-wider">Data</div>
                </div>
                <div class="text-center group hover:transform hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-300 mb-2">Secure</div>
                    <div class="text-sm text-gray-300 font-medium uppercase tracking-wider">System</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Fitur Unggulan</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Dirancang untuk kebutuhan akademik modern dengan teknologi terkini.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Presensi Cepat</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Sistem pencatatan kehadiran yang cepat dan efisien, meminimalisir antrian dan kesalahan data.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Laporan Realtime</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Pantau kehadiran mahasiswa secara langsung dengan dashboard analitik yang informatif.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass p-8 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-pink-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Keamanan Data</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Data kehadiran tersimpan aman dengan enkripsi dan sistem otentikasi yang handal.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-black/20 backdrop-blur-lg relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <span class="text-xl font-bold tracking-tighter">
                        <span class="text-blue-400">Absensi</span><span class="text-white">Mahasiswa</span>
                    </span>
                    <p class="text-gray-500 text-sm mt-2">© {{ date('Y') }} by di.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        new Typed('#typed-output', {
            strings: ['Lebih Cerdas & Efisien', 'Lebih Cepat & Akurat', 'Terintegrasi & Modern'],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true,
            backDelay: 2000
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('glass', 'shadow-lg');
            } else {
                navbar.classList.remove('glass', 'shadow-lg');
            }
        });
    </script>
</body>
</html>
