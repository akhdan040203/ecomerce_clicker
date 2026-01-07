<x-layout>
<div x-data="shopPage()" x-init="init()" class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="pt-32 pb-12 px-6 lg:px-8 bg-white border-b border-gray-100">
        <div class="mx-auto max-w-7xl">
            <nav class="flex mb-4 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-sky-600 transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-900 font-bold">Shop</li>
                </ol>
            </nav>
            
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight sm:text-6xl">Our <span class="text-sky-600">Store</span></h1>
                    <p class="mt-4 text-lg text-slate-600 max-w-2xl">
                        Explore our full range of premium mechanical keyboards, high-performance switches, and custom keycaps.
                    </p>
                </div>

                <!-- Search & Filters -->
                <div class="w-full lg:max-w-md">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="search" 
                               @input.debounce.500ms="fetchProducts()"
                               class="block w-full pl-11 pr-4 py-4 bg-gray-50 border-2 border-transparent focus:border-sky-500 focus:bg-white rounded-2xl text-slate-900 placeholder-gray-400 transition-all outline-none" 
                               placeholder="Search for something specific...">
                    </div>
                </div>
            </div>

            <!-- Categories Pills -->
            <div class="mt-12 flex flex-wrap gap-3">
                <button @click="filterByCategory(null)" 
                        :class="activeCategory === null ? 'bg-sky-600 text-white shadow-lg shadow-sky-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="px-6 py-2.5 rounded-full text-sm font-bold transition-all cursor-pointer">
                    All Products
                </button>
                <template x-for="cat in categories" :key="cat.id">
                    <button @click="filterByCategory(cat.slug)" 
                            :class="activeCategory === cat.slug ? 'bg-sky-600 text-white shadow-lg shadow-sky-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all cursor-pointer"
                            x-text="cat.name">
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <div class="px-6 lg:px-8 py-16">
        <div class="mx-auto max-w-7xl">
            <!-- Results Info -->
            <div class="mb-8 flex items-center justify-between">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">
                    Showing <span class="text-slate-900" x-text="products.length"></span> Results
                </p>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center items-center py-24">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 bg-sky-600 rounded-full animate-bounce"></div>
                    <div class="w-3 h-3 bg-sky-600 rounded-full animate-bounce [animation-delay:-.3s]"></div>
                    <div class="w-3 h-3 bg-sky-600 rounded-full animate-bounce [animation-delay:-.5s]"></div>
                </div>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && products.length === 0" class="text-center py-24 bg-white rounded-[3rem] shadow-sm border-2 border-dashed border-gray-100">
                <div class="mb-6 flex justify-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-8">Try adjusting your search or filters to find what you're looking for.</p>
                <button @click="search = ''; activeCategory = null; fetchProducts();" class="px-8 py-3 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-colors">
                    Clear all filters
                </button>
            </div>

            <!-- Product Grid -->
            <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <template x-for="product in products" :key="product.id">
                    <div @click="window.location.href = '/detail/' + product.slug" 
                         class="bg-white rounded-lg shadow-sm hover:shadow-2xl transition-all duration-500 group border border-gray-50 hover:border-sky-100 flex flex-col h-full relative overflow-hidden cursor-pointer">
                        <div class="absolute top-6 right-6 z-10">
                            <button @click.stop="" class="bg-white/80 backdrop-blur-md p-2 rounded-xl text-gray-400 hover:text-red-500 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" stroke-linecap="round"/></svg>
                            </button>
                        </div>

                        <!-- Top Half: Full Image -->
                        <div class="bg-gray-50 h-[220px] overflow-hidden group-hover:bg-sky-50/50 transition-colors duration-500">
                            <img :src="product.image || 'https://via.placeholder.com/300x300?text=' + product.name" 
                                 :alt="product.name" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <!-- Bottom Half: Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="mb-4 flex-grow px-2">
                                <span class="text-[10px] text-sky-600 font-black uppercase tracking-widest mb-2 inline-block" x-text="product.category.name"></span>
                                <h3 class="font-bold text-slate-900 text-lg line-clamp-2 leading-tight group-hover:text-sky-600 transition-colors" x-text="product.name"></h3>
                                <div class="flex items-center gap-1 mt-2 text-yellow-400 text-[10px]">
                                    ★★★★★ <span class="text-gray-400 font-bold ml-1">(4.8)</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-auto px-2">
                                <div>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Price</p>
                                    <p class="text-base font-black text-slate-900" x-text="product.formatted_price"></p>
                                </div>
                                <button @click.stop="addToCart($event, product)" 
                                        class="bg-sky-600 text-white p-3 rounded-xl hover:bg-sky-700 transition-all shadow-md active:scale-95 group/cart">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
function shopPage() {
    return {
        categories: [],
        products: [],
        loading: false,
        search: '',
        activeCategory: null,

        async init() {
            await this.fetchCategories();
            await this.fetchProducts();
        },

        async fetchCategories() {
            try {
                const response = await axios.get('/categories');
                this.categories = response.data.data;
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },

        async fetchProducts() {
            this.loading = true;
            try {
                let url = '/products';
                const params = new URLSearchParams();
                if (this.activeCategory) params.append('category', this.activeCategory);
                if (this.search) params.append('search', this.search);
                
                const response = await axios.get(url + '?' + params.toString());
                this.products = response.data.data;
            } catch (error) {
                console.error('Error fetching products:', error);
            } finally {
                this.loading = false;
            }
        },

        filterByCategory(slug) {
            this.activeCategory = slug;
            this.fetchProducts();
        },

        async addToCart(e, product) {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Trigger flying animation
            window.animateToCart(e, product.image);

            try {
                await axios.post('/cart', {
                    product_id: product.id,
                    quantity: 1
                });
                
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } catch (error) {
                console.error('Error adding to cart:', error);
                if (error.response && error.response.status === 401) {
                    window.location.href = '/login';
                } else {
                    toast.error('Failed to add product to cart. Please try again.');
                }
            }
        }
    }
}
</script>
</x-layout>
