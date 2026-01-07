<x-layout>
<div class="bg-white min-h-screen" x-data="productDetail('{{ $slug }}')">
    <div x-show="loading" class="flex flex-col items-center justify-center py-32 h-screen">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-sky-600 mb-4"></div>
        <p class="text-slate-500 font-bold uppercase tracking-widest animate-pulse text-sm">Loading Premium Product...</p>
    </div>

    <div x-show="!loading && product.id" x-cloak class="mx-auto max-w-7xl px-6 lg:px-8 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-12">
            <a href="/" class="hover:text-sky-600 transition-colors">Home</a>
            <span class="text-slate-300">/</span>
            <a href="/shop" class="hover:text-sky-600 transition-colors">Shop</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-900" x-text="product.name"></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left: Image Gallery -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-gray-50 rounded-[2rem] overflow-hidden min-h-[500px] group relative border border-gray-100 shadow-sm">
                    <img :src="product.image || 'https://via.placeholder.com/600x600?text=' + product.name" 
                         :alt="product.name" 
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                </div>
                
                <!-- Thumbnails Placeholder -->
                <div class="grid grid-cols-5 gap-4">
                    <template x-for="i in 5">
                        <div class="aspect-square bg-gray-50 rounded-2xl border border-gray-100 hover:border-sky-500 cursor-pointer transition-all overflow-hidden p-2 flex items-center justify-center group">
                            <img :src="product.image || 'https://via.placeholder.com/150x150?text=' + product.name" 
                                 class="max-h-full object-contain opacity-50 group-hover:opacity-100 transition-opacity">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="lg:col-span-12 xl:col-span-5 flex flex-col pt-4">
                <div class="mb-4">

                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight mb-4 tracking-tighter" x-text="product.name"></h1>
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="relative flex items-center">
                            <input type="radio" id="compare" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border-2 border-slate-200 checked:border-sky-600 transition-all">
                            <span class="absolute left-1/2 top-1/2 h-2.5 w-2.5 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-sky-600 opacity-0 peer-checked:opacity-100 transition-opacity"></span>
                        </div>
                        <label for="compare" class="text-xs font-bold text-slate-400 uppercase tracking-widest cursor-pointer hover:text-sky-600 transition-colors">Add to Compare</label>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="flex items-baseline gap-4 mb-8">
                    <p class="text-3xl font-black text-slate-900" x-text="product.formatted_price"></p>
                    <p class="text-lg text-slate-400 line-through font-bold" x-text="'Rp ' + (product.price * 1.2).toLocaleString('id-ID')"></p>
                    <span class="bg-sky-600 text-white text-[10px] font-black px-2 py-1 rounded inline-block uppercase tracking-widest ml-2">Sale</span>
                </div>

                <!-- Stock Information -->
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" :class="product.stock > 10 ? 'text-emerald-500' : (product.stock > 0 ? 'text-amber-500' : 'text-rose-500')" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest" :class="product.stock > 10 ? 'text-emerald-600' : (product.stock > 0 ? 'text-amber-600' : 'text-rose-600')">
                                <span x-show="product.stock > 0">
                                    <span x-text="product.stock"></span> Units Available
                                </span>
                                <span x-show="product.stock === 0">Out of Stock</span>
                            </p>
                            <p class="text-[10px] text-slate-400 font-bold mt-0.5" x-show="product.stock > 0 && product.stock <= 10">
                                Hurry! Only a few left in stock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-slate-500 font-bold mb-10 pb-8 border-b border-gray-100 leading-relaxed">
                    <span class="text-sky-600 cursor-pointer hover:underline">Shipping</span> calculated at checkout.
                </div>

                <!-- Variants Placeholder -->
                <div class="space-y-8 mb-10">
                    <div>
                        <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-4">Keyboard + Jacket</p>
                        <div class="flex flex-wrap gap-3">
                            <button class="px-6 py-2.5 bg-black text-white text-xs font-bold rounded-full border border-black transition-all">Keyboard Only</button>
                            <button class="px-6 py-2.5 bg-white text-slate-400 text-xs font-bold rounded-full border border-gray-200 hover:border-black hover:text-black transition-all">Keyboard + Jacket</button>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-4">Switch Option</p>
                        <div class="flex flex-wrap gap-3">
                            <button class="px-6 py-2.5 bg-black text-white text-xs font-bold rounded-full border border-black transition-all">Barebones</button>
                            <button class="px-6 py-2.5 bg-white text-slate-400 text-xs font-bold rounded-full border border-gray-200 hover:border-black hover:text-black transition-all">Gateron Brown</button>
                            <button class="px-6 py-2.5 bg-white text-slate-400 text-xs font-bold rounded-full border border-gray-200 hover:border-black hover:text-black transition-all">Gateron Pro Yellow</button>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Actions -->
                <div class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Quantity</label>
                        <div class="flex items-center w-32 bg-white border border-gray-300 rounded-md p-1">
                            <button @click="quantity > 1 ? quantity-- : null" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-black transition-all text-xl">-</button>
                            <input type="number" x-model="quantity" class="w-full bg-transparent border-none text-center font-bold text-sm focus:ring-0" min="1">
                            <button @click="quantity++" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-black transition-all text-xl">+</button>
                        </div>
                    </div>

                    <div class="pt-6 space-y-3">
                        <button @click="addToCart($event)" 
                                class="w-full bg-slate-900 text-white py-4 rounded-xl font-black text-sm uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-xl shadow-gray-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-[0.98]"
                                :disabled="adding || product.stock === 0">
                            <span x-show="!adding && product.stock > 0" class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Add to cart
                            </span>
                            <span x-show="adding">Adding...</span>
                            <span x-show="product.stock === 0 && !adding" class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Out of Stock
                            </span>
                        </button>
                        <button class="w-full bg-black text-white py-4 rounded-md font-black text-sm uppercase tracking-[0.2em] hover:bg-slate-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="product.stock === 0">
                            Buy it now
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
function productDetail(slug) {
    return {
        product: {},
        loading: true,
        adding: false,
        quantity: 1,

        async init() {
            console.log('Fetching product with slug:', slug);
            try {
                // baseURL is already set to '/api' in app.js
                const response = await axios.get(`/products/${slug}`);
                console.log('Product data received:', response.data);
                this.product = response.data.data;
            } catch (error) {
                console.error('Error fetching product detail:', error);
                console.log('Full error response:', error.response);
                window.location.href = '/shop'; 
            } finally {
                this.loading = false;
            }
        },

        async addToCart(e) {
            if (!localStorage.getItem('auth_token')) {
                window.location.href = '/login';
                return;
            }

            // Trigger flying animation
            window.animateToCart(e, this.product.image);

            this.adding = true;
            try {
                // baseURL is already set to '/api' in app.js
                await axios.post('/cart', {
                    product_id: this.product.id,
                    quantity: this.quantity
                });
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } catch (error) {
                console.error('Error adding to cart:', error);
                toast.error('Oops! Failed to add product. Please try again.');
            } finally {
                this.adding = false;
            }
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
</x-layout>
