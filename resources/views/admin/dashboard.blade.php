<x-admin-layout>
    <x-slot:title>Admin Dashboard</x-slot>

    <div x-data="adminDashboard()" x-init="init()" class="space-y-10">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Sales -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col gap-4">
                <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 8V7m0 1v1m0 9v1m0-1v-1m4-10a4 4 0 11-8 0 4 4 0 018 0zM3 12a9 9 0 1118 0 9 9 0 01-18 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Sales</p>
                    <h3 class="text-2xl font-black text-slate-900" x-text="stats.total_sales || 'Rp 0'"></h3>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Orders</p>
                    <h3 class="text-2xl font-black text-slate-900" x-text="stats.total_orders || 0"></h3>
                </div>
            </div>

            <!-- Total Products -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col gap-4">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Products</p>
                    <h3 class="text-2xl font-black text-slate-900" x-text="stats.total_products || 0"></h3>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col gap-4">
                <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Categories</p>
                    <h3 class="text-2xl font-black text-slate-900" x-text="stats.total_categories || 0"></h3>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section (Placeholder for now) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">Recent Orders</h3>
                <div class="space-y-6">
                    <p class="text-sm text-gray-500 italic">Feature coming soon...</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">Quick Links</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="/admin/products" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-sky-600 transition-all flex items-center gap-2">
                        Add New Product
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="/admin/categories" class="bg-gray-100 text-slate-700 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-sky-100 transition-all flex items-center gap-2">
                        Manage Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function adminDashboard() {
        return {
            stats: {
                total_sales: 'Rp 5.250.000', // Dummy for now
                total_orders: 12,
                total_products: 45,
                total_categories: 8
            },
            async init() {
                // Future: Fetch real stats from API
                console.log('Admin Dashboard Initialized');
            }
        }
    }
    </script>
</x-admin-layout>
