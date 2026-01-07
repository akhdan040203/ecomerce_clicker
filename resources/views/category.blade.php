<x-layout>
<div x-data="categoryPage()" x-init="init()" class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="pt-32 pb-12 px-6 lg:px-8 bg-white">
        <div class="mx-auto max-w-7xl">
            <nav class="flex mb-4 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-sky-600">Home</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-900 font-bold" x-text="categoryName"></li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight sm:text-5xl" x-text="categoryName"></h1>
                    <p class="mt-4 text-lg text-slate-600 max-w-3xl">
                        Discover our curated collection of <span class="text-sky-600" x-text="categoryName"></span>. 
                        Premium quality and performance for your setup.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid Section -->
    <div class="px-6 lg:px-8 py-16">
        <div class="mx-auto max-w-7xl">
            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center items-center py-24">
                <div class="relative w-16 h-16">
                    <div class="absolute top-0 left-0 w-full h-full border-4 border-sky-100 rounded-full"></div>
                    <div class="absolute top-0 left-0 w-full h-full border-4 border-sky-600 rounded-full animate-spin border-t-transparent"></div>
                </div>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && products.length === 0" class="text-center py-24 bg-white rounded-3xl shadow-sm">
                <div class="mb-4 flex justify-center text-gray-300">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5" stroke-linecap="round"/></svg>
                </div>
                <p class="text-gray-500 text-xl font-medium">No products found for this category.</p>
                <a href="/" class="mt-6 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-sky-600 hover:bg-sky-700 shadow-md">
                    Back to Home
                </a>
            </div>

            <!-- Product Grid -->
            <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
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
function categoryPage() {
    return {
        slug: '{{ $slug }}',
        categoryName: '',
        products: [],
        loading: false,

        async init() {
            // First find category name from API
            await this.fetchCategoryDetails();
            await this.fetchProducts();
        },

        async fetchCategoryDetails() {
            try {
                const response = await axios.get('/categories');
                const cat = response.data.data.find(c => c.slug === this.slug);
                if (cat) {
                    this.categoryName = cat.name;
                } else {
                    this.categoryName = this.slug.charAt(0).toUpperCase() + this.slug.slice(1);
                }
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },

        async fetchProducts() {
            this.loading = true;
            try {
                const response = await axios.get('/products?category=' + this.slug);
                this.products = response.data.data;
            } catch (error) {
                console.error('Error fetching products:', error);
            } finally {
                this.loading = false;
            }
        },

        async addToCart(e, product) {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Trigger flying animation
            if (window.animateToCart) {
                window.animateToCart(e, product.image);
            }

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
