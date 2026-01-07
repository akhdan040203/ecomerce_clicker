<header class="fixed inset-x-0 top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100/50">
    <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
      <div class="flex lg:flex-3 items-center gap-x-6">
        <a href="/" class="-m-1.5 p-1.5 flex items-center gap-x-3">
          <img src="/images/logo.png" alt="Clicker Logo" class="h-10 w-auto" />
          <span class="text-2xl font-bold text-slate-900">Clicker</span>
        </a>

        <!-- Search Form -->
        <div class="flex items-center rounded-full bg-gray-100 ring-1 ring-gray-300 relative" x-data="searchComponent()">
          <form class="hidden lg:flex flex-1 max-w-md items-center" @submit.prevent="window.location.href = '/shop?search=' + query">
            <div class="relative flex-1">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
              </div>
              <input 
                type="search" 
                name="search" 
                id="search" 
                x-model.debounce.300ms="query"
                @input="search()"
                @focus="query.length >= 2 && results.length > 0 ? showDropdown = true : null"
                @click.away="showDropdown = false"
                class="block w-full rounded-l-full border-0 bg-transparent py-1 pl-9 pr-3 text-slate-800 placeholder:text-gray-400 focus:outline-none focus:ring-0 sm:text-sm sm:leading-6" 
                placeholder="Search keyboards..."
                autocomplete="off"
              >
            </div>
          </form>

          <!-- Search Dropdown -->
          <div x-show="showDropdown" 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 translate-y-1"
               x-transition:enter-end="opacity-100 translate-y-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="opacity-100 translate-y-0"
               x-transition:leave-end="opacity-0 translate-y-1"
               class="absolute left-0 top-full z-50 mt-2 w-full max-w-md rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-gray-900/5 focus:outline-none overflow-hidden"
               style="display: none;">
            
            <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 mb-1">
               Suggestions
            </div>

            <template x-for="product in results" :key="product.id">
              <a :href="'/detail/' + product.slug" 
                 class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-sky-50 transition-colors group">
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex-shrink-0 flex items-center justify-center p-1">
                    <img :src="product.image || 'https://via.placeholder.com/50?text=K'" :alt="product.name" class="w-full h-full object-contain">
                </div>
                <div class="flex-grow">
                    <div class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors" x-text="product.name"></div>
                    <div class="text-[10px] text-gray-400 font-medium" x-text="product.category.name"></div>
                </div>
                <div class="text-xs font-black text-slate-900" x-text="product.formatted_price"></div>
              </a>
            </template>

            <div x-show="loading" class="flex justify-center py-4">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-sky-500"></div>
            </div>

            <div x-show="!loading && results.length === 0" class="px-3 py-4 text-center text-sm text-gray-500">
                No products found for "<span class="font-bold text-slate-900" x-text="query"></span>"
            </div>
            
            <a :href="'/shop?search=' + query" 
               class="block mt-1 px-3 py-2 text-center text-[11px] font-black text-sky-600 uppercase tracking-wider hover:bg-sky-50 rounded-xl transition-colors border-t border-gray-50">
               View all results
            </a>
          </div>
        </div>
      </div>
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-slate-700">
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12" x-data="{ open: false, categories: [] }" x-init="categories = (await axios.get('/categories')).data.data">
        <a href="/" class="text-sm/6 font-semibold text-slate-800 hover:text-sky-600">Home</a>
        
        <!-- Category Dropdown -->
        <div class="relative">
          <button @click="open = !open" @click.away="open = false" class="flex items-center gap-x-1 text-sm/6 font-semibold text-slate-800 focus:outline-none cursor-pointer hover:text-sky-600">
            Categories
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </button>

          <div x-show="open" 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 translate-y-1"
               x-transition:enter-end="opacity-100 translate-y-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="opacity-100 translate-y-0"
               x-transition:leave-end="opacity-0 translate-y-1"
               class="absolute -left-8 top-full z-10 mt-3 w-56 rounded-xl bg-white p-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
            
            <template x-for="category in categories" :key="category.id">
              <a :href="'/category/' + category.slug" 
                 class="block rounded-lg px-3 py-2 text-sm font-semibold leading-6 text-slate-900 hover:bg-gray-50"
                 x-text="category.name">
              </a>
            </template>
          </div>
        </div>

        <a href="/shop" class="text-sm/6 font-semibold text-slate-800 hover:text-sky-600">Shop</a>
        <a href="#" class="text-sm/6 font-semibold text-slate-800 hover:text-sky-600">Customizer</a>
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-6 lg:items-center" x-data="navbarAuth()" x-init="init()">
        <!-- Cart Icon -->
        <a href="/cart" id="navbar-cart" 
           :class="{ 'cart-animate': animateCart }" 
           @animationend="animateCart = false"
           class="relative group p-2 rounded-full hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6 text-slate-700 group-hover:text-sky-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <template x-if="cartCount > 0">
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full" x-text="cartCount"></span>
          </template>
        </a>

        <div class="h-6 w-[1px] bg-gray-200 mx-1"></div>

        <!-- Not Logged In -->
        <template x-if="!isLoggedIn">
          <div class="flex gap-x-6">
            <a href="/login" class="text-sm/6 font-semibold text-slate-800 hover:text-sky-600">Log in</a>
            <a href="/register" class="text-sm/6 font-semibold text-white bg-sky-600 px-4 py-2 rounded-lg hover:bg-sky-700">Sign up</a>
          </div>
        </template>

        <!-- Logged In -->
        <template x-if="isLoggedIn">
          <div class="flex items-center gap-x-4 relative" x-data="{ openProfile: false }">
            <button @click="openProfile = !openProfile" @click.away="openProfile = false" 
                    class="flex items-center gap-x-2 p-1 rounded-full hover:bg-gray-100 transition-all focus:outline-none ring-offset-2 focus:ring-2 focus:ring-sky-500">
              <div class="w-9 h-9 bg-sky-600 text-white rounded-full flex items-center justify-center font-black text-sm shadow-md">
                <span x-text="userName ? userName.charAt(0).toUpperCase() : 'U'"></span>
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
                 class="absolute right-0 top-full z-50 mt-2 w-48 rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-gray-900/5 focus:outline-none"
                 style="display: none;">
              
              <div class="px-3 py-2 border-b border-gray-50 mb-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Logged in as</p>
                <p class="text-xs font-black text-slate-900 truncate" x-text="userName"></p>
              </div>

              <a href="/profile" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition-all group">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Edit Profile
              </a>

              <button @click="handleLogout()" :disabled="loading"
                      class="w-full flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition-all group">
                <svg class="w-4 h-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span x-show="!loading">Logout</span>
                <span x-show="loading">Logging out...</span>
              </button>
            </div>
          </div>
        </template>
      </div>
    </nav>
    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
            <div class="flex items-center justify-between">
              <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Keyboard Store</span>
                <img src="/images/logo.png" alt="Keyboard Store Logo" class="h-10 w-auto" />
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-200">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-white/10">
                <div class="space-y-2 py-6">
                  <a href="/" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Home</a>
                  <a href="/shop" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Shop</a>
                  <a href="/cart" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Cart</a>
                </div>
                <div class="py-6">
                  <template x-if="!isLoggedIn">
                    <a href="/login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                  </template>
                  <template x-if="isLoggedIn">
                    <button @click="handleLogout()" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-red-400 hover:bg-white/5 w-full text-left">Logout</button>
                  </template>
                </div>
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>
  </header>

<script>
function navbarAuth() {
    return {
        isLoggedIn: false,
        userName: '',
        loading: false,
        cartCount: 0,
        animateCart: false,

        async init() {
            await this.checkAuth();
            if (this.isLoggedIn) {
                await this.fetchCartCount();
            }

            // Listen for cart update events
            window.addEventListener('cart-updated', async () => {
                if (this.isLoggedIn) {
                    await this.fetchCartCount();
                }
            });

            // Listen for animation finished to trigger jiggle
            window.addEventListener('cart-animation-finished', () => {
                this.animateCart = true;
            });
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

        async fetchCartCount() {
            try {
                const response = await axios.get('/cart');
                this.cartCount = response.data.meta.total_items;
            } catch (error) {
                console.error('Error fetching cart count:', error);
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

function searchComponent() {
    return {
        query: '',
        results: [],
        showDropdown: false,
        loading: false,

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                this.showDropdown = false;
                return;
            }

            this.loading = true;
            this.showDropdown = true;
            
            try {
                const response = await axios.get(`/products?search=${this.query}`);
                this.results = response.data.data.slice(0, 5);
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
