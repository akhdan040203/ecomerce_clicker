<x-layout>
<div x-data="homePage()" x-init="init()">
    <!-- Hero Section -->
    <div class="pt-24 pb-12 px-6 mt-12 lg:px-8">
      <div class="mx-auto max-w-7xl ">
        <div class="text-center ">
          <h1 class="text-5xl font-bold tracking-tight text-slate-900 sm:text-6xl lg:text-7xl">
            The best mechanical<br>
            <p class="text-sky-600"><span class="text-slate-500 font-semibold">keyboards</span> <span class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-sky-500 block sm:inline to-purple-500 ">for you</span></p>
          </h1>
        </div>
      </div>
        <!-- Category Icons Information -->
        <div class="mt-8 flex flex-wrap justify-center gap-8 md:gap-12">
            <!-- Keyboard Mechanical -->
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-lg p-2 transition-all hover:scale-110">
                    <img src="/images/categories/icon-keyboard.png" alt="Keyboard Mechanical" class="w-12 h-12 object-contain">
                </div>
                <span class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mechanical</span>
            </div>

            <!-- Switches -->
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-lg p-2 transition-all hover:scale-110">
                    <img src="/images/categories/icon-switches.png" alt="Switches" class="w-12 h-12 object-contain">
                </div>
                <span class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Switches</span>
            </div>

            <!-- Keycaps -->
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-lg p-2 transition-all hover:scale-110">
                    <img src="/images/categories/icon-keycaps.png" alt="Keycaps" class="w-12 h-12 object-contain">
                </div>
                <span class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Keycaps</span>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="px-6 lg:px-8 mt-8 pb-16">
      <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Featured Product Card -->
          <div class="bg-gradient-to-br from-gray-200 via-gray-50 to-gray-100 rounded-3xl shadow-md hover:shadow-xl transition-shadow overflow-hidden p-6">
            <div class="flex items-center gap-2 mb-2">
              <span class="bg-white/90 text-teal-600 text-xs font-semibold px-2 py-1 rounded-full">NEW</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-900 mb-1 mt-5 text-center">Seal PBT</h3>
            <h4 class="text-2xl font-semibold text-slate-800 mb-2 text-center">Keycaps V3</h4>
            <p class="text-xl font-semibold text-slate-700 mb-6 text-center">$64.99</p>

            <div class="flex items-end justify-end -mr-6 -mb-6 overflow-hidden">
              <img src="/images/foto-keyboard3.png" alt="Seal PBT Keycaps V3"
                   class="w-full h-auto max-w-[600px] object-contain drop-shadow-2xl md:hover:scale-110 transition-transform cursor-pointer">
            </div>
          </div>

          <!-- Featured Switches -->
          <div class="bg-white rounded-3xl shadow-md p-6 hover:shadow-xl transition-shadow">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Featured<br>Switches</h3>

            <div class="space-y-4">
              <div class="flex items-center gap-3 p-6 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer bg-slate-100 overflow-hidden">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center transition-transform md:hover:scale-125">
                  <img src="images/card2/red-switch.png" alt="red-switch">
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Red Switch</p>
                  <p class="text-sm text-gray-500">Linear</p>
                </div>
              </div>

              <div class="flex items-center gap-3 p-6 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer bg-slate-100 overflow-hidden">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center md:hover:scale-125 transition-transform">
                  <img src="images/card2/blue-switch.png" alt="blue-switch">
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Blue Switch</p>
                  <p class="text-sm text-gray-500">Clicky</p>
                </div>
              </div>

              <div class="flex items-center gap-3 p-6 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer bg-slate-100 overflow-hidden">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center md:hover:scale-125 transition-transform">
                  <img src="images/card2/silver-switch.png" alt="silver-switch">
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Silver Switch</p>
                  <p class="text-sm text-gray-500">Linear</p>
                </div>
              </div>
            </div>

            <!-- tombol harus di dalam card ini -->
            <button class="mt-6 w-full text-sky-600 cursor-pointer font-semibold py-2 rounded-xl hover:bg-blue-50 transition-colors flex items-center justify-center gap-2">
              Need some help?
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </button>
          </div>

          <!-- Customize CTA Card -->
          <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-[2px] rounded-3xl h-full">
            <div class="bg-gradient-to-tr from-purple-100 to-gray-50 rounded-3xl shadow-md hover:shadow-xl transition-shadow p-8 h-full flex flex-col">
              <h3 class="text-2xl font-bold text-slate-900">
                Customize <span class="text-sky-600">your</span>
              </h3>
              <h3 class="text-2xl font-bold text-sky-600 mb-4">
                own keyboard
              </h3>
              <p class="text-sm text-slate-600 mb-6">
                Choose from various layouts, switches, and keycaps to build your dream keyboard
              </p>
              <div class="rounded-2xl p-8 flex flex-col items-center justify-center text-center flex-1 mb-8">
               <img src="/images/foto-keyboard2.png" alt="" class="w-[380px] max-w-none transition-transform md:hover:scale-125 cursor-pointer">
              </div>
              <button class="mt-auto w-full bg-sky-600 text-white font-semibold py-4 rounded-xl
                            hover:bg-sky-700 transition-colors flex items-center justify-center gap-2 cursor-pointer">
                Start Building
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Cards Section -->
    <div class="px-6 lg:px-8 pt-20 pb-16">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="category in categories" :key="category.id">
                    <a :href="'/category/' + category.slug" 
                       class="relative group overflow-hidden rounded-[2.5rem] bg-white shadow-lg hover:shadow-2xl transition-all duration-500 h-[250px] flex items-center justify-center border border-gray-50">
                        <!-- Background Accent -->
                        <div :class="getCategoryStyle(category.slug)" class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity"></div>
                        
                        <div class="relative z-10 text-center px-6">
                            <h3 class="text-3xl font-black text-slate-900 group-hover:text-sky-600 transition-colors uppercase tracking-widest leading-tight" x-text="category.name"></h3>
                            <div class="mt-3 flex items-center justify-center gap-2 text-sky-600 font-bold text-xs uppercase tracking-[0.3em] opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                Explore Now
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                        
                        <!-- Decorative Element -->
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-slate-900/5 group-hover:scale-125 transition-transform duration-700"></div>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- Featured Products Grid -->
    <div class="px-6 lg:px-8 pt-24 pb-16 bg-gray-100">
      <div class="mx-auto max-w-7xl">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-3xl font-bold text-slate-900">
                Featured <span class="text-gray-400">Products</span>
            </h2>
          </div>
          <a href="/shop" class="text-sky-600 font-semibold hover:text-sky-700 flex items-center gap-1">
            View all
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </a>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center items-center py-20">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-sky-500"></div>
        </div>

        <!-- Empty State -->
        <div x-show="!loading && products.length === 0" class="text-center py-20">
            <p class="text-gray-500 text-xl font-medium">No products found for this category.</p>
        </div>

        <!-- Product Grid -->
        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <template x-for="product in products.slice(0, 6)" :key="product.id">
                <div class="bg-white rounded-lg shadow-sm hover:shadow-xl transition-all duration-500 group border border-transparent hover:border-sky-100 flex flex-col h-full relative overflow-hidden">
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
                            <a :href="'/detail/' + product.slug">
                                <h3 class="font-bold text-slate-900 text-lg line-clamp-2 leading-tight group-hover:text-sky-600 transition-colors" x-text="product.name"></h3>
                            </a>
                            <div class="flex items-center gap-1 mt-2 text-yellow-400 text-[10px]">
                                ★★★★★ <span class="text-gray-400 font-bold ml-1">(4.8)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto px-2">
                            <div>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Price</p>
                                <p class="text-base font-black text-slate-900" x-text="product.formatted_price"></p>
                            </div>
                            <a :href="'/detail/' + product.slug" 
                               class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2.5 rounded-xl hover:bg-sky-600 transition-all shadow-md active:scale-95 text-sm font-bold group/btn">
                               <span>Detail</span>
                               <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>
      </div>
    </div>
</div>

<script>
function homePage() {
    return {
        categories: [],
        products: [],
        loading: false,
        activeCategory: null,
        activeCategoryName: '',

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
                if (this.activeCategory) {
                    url += '?category=' + this.activeCategory;
                }
                const response = await axios.get(url);
                this.products = response.data.data;
            } catch (error) {
                console.error('Error fetching products:', error);
            } finally {
                this.loading = false;
            }
        },

        filterByCategory(slug) {
            this.activeCategory = slug;
            if (slug) {
                const cat = this.categories.find(c => c.slug === slug);
                this.activeCategoryName = cat ? cat.name : '';
            } else {
                this.activeCategoryName = '';
            }
            this.fetchProducts();
        },

        getCategoryImage(slug) {
            const images = {
                'keyboards': '/images/categories/icon-keyboard.png',
                'switches': '/images/categories/icon-switches.png',
                'keycaps': '/images/categories/icon-keycaps.png'
            };
            return images[slug] || '/images/categories/default.png';
        },

        getCategoryStyle(slug) {
            const styles = {
                'keyboards': 'bg-gradient-to-br from-pink-100 to-rose-200',
                'switches': 'bg-gradient-to-br from-amber-100 to-orange-200',
                'keycaps': 'bg-gradient-to-br from-teal-100 to-cyan-200',
                'mouse': 'bg-gradient-to-br from-indigo-100 to-purple-200',
                'headseat': 'bg-gradient-to-br from-emerald-100 to-green-200',
                'accessories': 'bg-gradient-to-br from-slate-100 to-gray-300'
            };
            return styles[slug] || 'bg-gray-100';
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
                
                // Dispatch event to update navbar
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
