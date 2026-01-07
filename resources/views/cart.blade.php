<x-layout>
<div x-data="cartPage()" x-init="init()" class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="pt-32 pb-12 px-6 lg:px-8 bg-white border-b border-gray-100">
        <div class="mx-auto max-w-7xl">
            <nav class="flex mb-4 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-sky-600 transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li><a href="/shop" class="hover:text-sky-600 transition-colors">Shop</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-900 font-bold">Your Cart</li>
                </ol>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight sm:text-6xl">Shopping <span class="text-sky-600">Cart</span></h1>
        </div>
    </div>

    <div class="px-6 lg:px-8 py-16">
        <div class="mx-auto max-w-7xl">
            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center items-center py-24">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-sky-600"></div>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && cartItems.length === 0" class="text-center py-24 bg-white rounded-[3rem] shadow-sm border border-gray-100">
                <div class="mb-6 flex justify-center">
                    <div class="w-24 h-24 bg-sky-50 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-4-4H8a4 4 0 00-4 4v4m14 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v4" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-8">Looks like you haven't added any premium gear to your cart yet.</p>
                <a href="/shop" class="inline-block px-8 py-4 bg-sky-600 text-white font-bold rounded-2xl hover:bg-sky-700 transition-all shadow-lg shadow-sky-100">
                    Go Shopping
                </a>
            </div>

            <!-- Cart Content -->
            <div x-show="!loading && cartItems.length > 0" class="flex flex-col lg:flex-row gap-12">
                <!-- Items List -->
                <div class="flex-grow space-y-6">
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-50 flex flex-col sm:flex-row items-center gap-6 group hover:shadow-xl transition-all duration-500">
                            <!-- Image -->
                            <div class="w-32 h-32 bg-gray-50 rounded-3xl overflow-hidden flex-shrink-0 group-hover:bg-sky-50 transition-colors">
                                <img :src="item.product.image || 'https://via.placeholder.com/300x300?text=' + item.product.name" 
                                     :alt="item.product.name" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>

                            <!-- Info -->
                            <div class="flex-grow text-center sm:text-left">
                                <span class="text-[10px] bg-sky-50 text-sky-600 font-bold px-2 py-1 rounded-md uppercase tracking-widest mb-2 inline-block" x-text="item.product.category.name"></span>
                                <h3 class="text-xl font-bold text-slate-900 mb-1" x-text="item.product.name"></h3>
                                <p class="text-sky-600 font-black" x-text="item.product.formatted_price"></p>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-4 bg-gray-100 rounded-2xl p-2">
                                <button @click="updateQuantity(item.id, item.quantity - 1)" 
                                        :disabled="item.quantity <= 1 || updating === item.id"
                                        class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-blue-600 disabled:opacity-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 12H4" stroke-width="3" stroke-linecap="round"/></svg>
                                </button>
                                <span class="text-lg font-black w-8 text-center text-slate-900" x-text="item.quantity"></span>
                                <button @click="updateQuantity(item.id, item.quantity + 1)" 
                                        :disabled="updating === item.id"
                                        class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-blue-600 disabled:opacity-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
                                </button>
                            </div>

                            <!-- Subtotal & Delete -->
                            <div class="text-right sm:min-w-[150px]">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Subtotal</p>
                                <p class="text-xl font-black text-slate-900 mb-2" x-text="item.formatted_subtotal"></p>
                                <button @click="removeItem(item.id)" 
                                        class="text-red-400 hover:text-red-600 font-bold text-xs uppercase tracking-widest flex items-center gap-1 justify-end ml-auto group/del">
                                    <svg class="w-4 h-4 group-hover/del:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-96">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-gray-50 sticky top-32">
                        <h2 class="text-2xl font-black text-slate-900 mb-8">Order Summary</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-slate-600">
                                <span class="font-medium">Subtotal (<span x-text="meta.total_items"></span> items)</span>
                                <span class="font-bold text-slate-900" x-text="meta.formatted_total_price"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span class="font-medium">Shipping</span>
                                <span class="text-emerald-500 font-black">FREE</span>
                            </div>
                            <div class="h-[1px] bg-gray-100 my-4"></div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 uppercase tracking-widest">Total</p>
                                    <p class="text-xs text-gray-400">Including VAT</p>
                                </div>
                                <p class="text-3xl font-black text-sky-600" x-text="meta.formatted_total_price"></p>
                            </div>
                        </div>

                        <button @click="handleCheckout()" :disabled="loading" class="w-full bg-sky-600 text-white py-5 rounded-2xl font-black text-lg hover:bg-sky-700 transition-all shadow-lg shadow-sky-100 mb-4 flex items-center justify-center gap-3 group disabled:opacity-50">
                            <span x-show="!loading">Checkout Now</span>
                            <span x-show="loading">Processing...</span>
                            <svg x-show="!loading" class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        
                        <button @click="clearCart()" class="w-full py-4 text-gray-400 hover:text-red-500 font-bold text-xs uppercase tracking-widest transition-colors">
                            Clear Shopping Cart
                        </button>

                        <!-- Extra Info -->
                        <div class="mt-8 pt-8 border-t border-gray-100 flex items-center gap-4 text-slate-400">
                            <svg class="w-10 h-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p class="text-[10px] font-bold uppercase tracking-wider leading-relaxed">
                                Secure checkout guaranteed. Your data is encrypted and protected.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cartPage() {
    return {
        cartItems: [],
        meta: {},
        loading: false,
        updating: null,

        async init() {
            // Check auth first
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            await this.fetchCart();
        },

        async fetchCart() {
            this.loading = true;
            try {
                const response = await axios.get('/cart');
                this.cartItems = response.data.data;
                this.meta = response.data.meta;
            } catch (error) {
                console.error('Error fetching cart:', error);
                if (error.response && error.response.status === 401) {
                    window.location.href = '/login';
                }
            } finally {
                this.loading = false;
            }
        },

        async updateQuantity(id, qty) {
            if (qty < 1) return;
            this.updating = id;
            try {
                await axios.put('/cart/' + id, { quantity: qty });
                await this.fetchCart();
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } catch (error) {
                console.error('Error updating quantity:', error);
                toast.error('Failed to update quantity. Please try again.');
            } finally {
                this.updating = null;
            }
        },

        async removeItem(id) {
            if (!confirm('Remove this product from cart?')) return;
            try {
                await axios.delete('/cart/' + id);
                await this.fetchCart();
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } catch (error) {
                console.error('Error removing item:', error);
                toast.error('Failed to remove item. Please try again.');
            }
        },

        async clearCart() {
            if (!confirm('Are you sure you want to clear your entire cart?')) return;
            try {
                await axios.delete('/cart');
                await this.fetchCart();
                window.dispatchEvent(new CustomEvent('cart-updated'));
            } catch (error) {
                console.error('Error clearing cart:', error);
                toast.error('Failed to clear cart. Please try again.');
            }
        },

        async handleCheckout() {
            this.loading = true;
            try {
                const response = await axios.post('/checkout');
                const snapToken = response.data.data.snap_token;

                window.snap.pay(snapToken, {
                    onSuccess: (result) => {
                        toast.success('Payment success!');
                        window.location.href = '/order/success';
                    },
                    onPending: (result) => {
                        toast.info('Payment pending. Please complete your payment.');
                        window.location.href = '/order/pending';
                    },
                    onError: (result) => {
                        toast.error('Payment failed!');
                        window.location.href = '/order/failed';
                    },
                    onClose: () => {
                        toast.warning('You closed the payment popup without finishing payment.');
                        this.loading = false;
                        // Reload cart in case some items were cleared but payment not done
                        this.fetchCart();
                    }
                });
            } catch (error) {
                console.error('Checkout error:', error);
                toast.error(error.response?.data?.message || 'Checkout failed. Please try again.');
                this.loading = false;
            }
        }
    }
}
</script>
</x-layout>
