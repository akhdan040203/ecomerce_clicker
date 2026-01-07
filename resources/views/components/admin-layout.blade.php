<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Admin Panel - Clicker</title>
</head>
<body class="bg-gray-50 font-['Inter']">
    <x-toast />
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 lg:static lg:translate-x-0 shrink-0">
            <div class="flex h-full flex-col">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between px-6 py-6 h-20 border-b border-slate-800">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center font-black text-white"></div>
                        <span class="text-xl font-black tracking-tighter">Admin<span class="text-sky-500">.</span></span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden">
                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 px-4 py-6 overflow-y-auto">
                    <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/dashboard') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                    <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/categories*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 11h.01M7 15h.01M10 7h10M10 11h10M10 15h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-sm">Categories</span>
                    </a>
                    <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/products*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-sm">Products</span>
                    </a>
                    <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/orders*') ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-sm">Orders</span>
                    </a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-slate-800">
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="font-semibold text-sm">Back to Store</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 shrink-0 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                        <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-lg font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                </div>

                <div class="flex items-center gap-4" x-data="navbarAuth()" x-init="init()">
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false" 
                                class="flex items-center gap-x-3 p-1 rounded-full hover:bg-gray-100 transition-all focus:outline-none ring-offset-2 focus:ring-2 focus:ring-sky-500">
                            <div class="hidden sm:flex flex-col items-end mr-1">
                                <span class="text-sm font-black text-slate-900 leading-tight" x-text="userName"></span>
                                <span class="text-[10px] uppercase font-black text-sky-600 tracking-wider">Administrator</span>
                            </div>
                            <div class="w-10 h-10 bg-sky-600 text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-sky-100">
                                <span x-text="userName ? userName.charAt(0).toUpperCase() : 'A'"></span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="openProfile ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-show="openProfile" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 top-full z-50 mt-2 w-56 rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-gray-900/5 focus:outline-none"
                             style="display: none;">
                          
                          <div class="px-4 py-3 border-b border-gray-50 mb-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Logged in as</p>
                            <p class="text-xs font-black text-slate-900 truncate" x-text="userName"></p>
                          </div>

                          <a href="/profile" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition-all group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Edit Profile
                          </a>

                          <a href="/" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition-all group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Go to Store
                          </a>

                          <div class="h-px bg-gray-50 my-1"></div>

                          <button @click="handleLogout()" :disabled="loading"
                                  class="w-full flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all group">
                            <svg class="w-4 h-4 text-rose-400 group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span x-show="!loading">Logout</span>
                            <span x-show="loading">Logging out...</span>
                          </button>
                        </div>
                    </div>
                </div>
            </header>

            <script>
            function navbarAuth() {
                return {
                    isLoggedIn: false,
                    userName: '',
                    loading: false,

                    async init() {
                        await this.checkAuth();
                    },

                    async checkAuth() {
                        const token = localStorage.getItem('auth_token');
                        if (!token) {
                            this.isLoggedIn = false;
                            return;
                        }

                        try {
                            const response = await axios.get('/user');
                            this.isLoggedIn = true;
                            this.userName = response.data.data.name;
                        } catch (error) {
                            localStorage.removeItem('auth_token');
                            this.isLoggedIn = false;
                        }
                    },

                    async handleLogout() {
                        this.loading = true;
                        try {
                            await axios.post('/logout');
                        } catch (error) {
                            console.error('Logout error:', error);
                        } finally {
                            localStorage.removeItem('auth_token');
                            delete axios.defaults.headers.common['Authorization'];
                            window.location.href = '/login';
                        }
                    }
                }
            }
            </script>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 md:p-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
