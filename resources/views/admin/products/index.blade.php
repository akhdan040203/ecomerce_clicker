<x-admin-layout>
    <x-slot:title>Manage Products</x-slot>

    <div x-data="productManagement({{ $categories->toJson() }})" class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Products List</h3>
                <p class="text-sm text-slate-500">Add, edit, and track your store inventory.</p>
            </div>
            <button @click="openModal('create')" class="bg-sky-600 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-sky-700 transition-all flex items-center gap-2 shadow-lg shadow-sky-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Add Product
            </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-8 py-5">Product Info</th>
                            <th class="px-8 py-5">Category</th>
                            <th class="px-8 py-5">Price</th>
                            <th class="px-8 py-5">Stock</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($products as $product)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0">
                                        @if($product->image)
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm leading-tight">{{ $product->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-black uppercase tracking-widest text-sky-600 bg-sky-50 px-3 py-1.5 rounded-lg">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-black text-slate-900 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold {{ $product->stock < 10 ? 'text-rose-600' : 'text-slate-600' }}">
                                    {{ $product->stock }} <span class="text-[10px] uppercase text-slate-400 ml-0.5">unit</span>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openModal('edit', {{ $product }})" class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                    <button @click="deleteProduct({{ $product->id }})" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between">
                <div class="text-xs text-slate-400 font-bold uppercase tracking-widest">
                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} Products
                </div>
                <div>
                    {{ $products->links('pagination::tailwind') }}
                </div>
            </div>

            @if($products->isEmpty())
            <div class="p-20 text-center">
                <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h4 class="font-bold text-slate-800 uppercase tracking-widest text-sm mb-1">No Products Found</h4>
                <p class="text-xs text-slate-400">Time to stock up your inventory!</p>
            </div>
            @endif
        </div>

        <!-- CRUD Modal -->
        <template x-teleport="body">
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                
                <div @click.away="showModal = false" 
                     class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden shadow-black/20">
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h4 class="text-lg font-black text-slate-800 uppercase tracking-widest" x-text="modalMode === 'create' ? 'Add New Product' : 'Edit Product'"></h4>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="saveProduct" class="p-10 grid grid-cols-2 gap-6">
                        <div class="col-span-2 space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Product Name</label>
                            <input type="text" x-model="form.name" required class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Category</label>
                            <select x-model="form.category_id" required class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800 appearance-none">
                                <option value="">Select Category</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Price (Rp)</label>
                            <input type="number" x-model="form.price" required class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Stock</label>
                            <input type="number" x-model="form.stock" required class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800">
                        </div>

                        <!-- Image Upload Area -->
                        <div class="col-span-2 space-y-4">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Product Image</label>
                            
                            <div class="flex items-start gap-6">
                                <!-- Preview Square -->
                                <div class="w-32 h-32 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden shrink-0 relative group">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <div class="text-center p-4">
                                            <svg class="w-8 h-8 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </template>
                                    
                                    <!-- Hover Overlay to Remove -->
                                    <template x-if="imagePreview">
                                        <div @click="removeImage" class="absolute inset-0 bg-rose-500/80 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </template>
                                </div>

                                <!-- Upload Controls -->
                                <div class="flex-1 space-y-3">
                                    <div class="relative">
                                        <input type="file" 
                                               @change="handleImageChange" 
                                               accept="image/png, image/jpeg, image/jpg"
                                               class="hidden" 
                                               id="product-image-input">
                                        <label for="product-image-input" 
                                               class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-200 rounded-xl font-bold text-xs uppercase tracking-widest text-slate-600 hover:border-sky-500 hover:text-sky-600 transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            Choose Image
                                        </label>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-bold leading-relaxed">
                                        PNG, JPG or JPEG. Max 2MB.<br>
                                        <span class="text-sky-500">Auto-resized to 500x500px.</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Description</label>
                            <textarea x-model="form.description" rows="3" class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800"></textarea>
                        </div>

                        <div class="col-span-2 flex gap-4 pt-4">
                            <button type="button" @click="showModal = false" class="flex-1 px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-500 bg-gray-100 hover:bg-gray-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" :disabled="loading" class="flex-[2] px-6 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-sky-600 transition-all shadow-lg shadow-gray-200 disabled:opacity-50">
                                <span x-show="!loading" x-text="modalMode === 'create' ? 'Create Product' : 'Save Changes'"></span>
                                <span x-show="loading">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
    function productManagement(initialCategories = []) {
        return {
            showModal: false,
            modalMode: 'create',
            loading: false,
            categories: initialCategories,
            imagePreview: null,
            imageFile: null,

            form: {
                id: null,
                category_id: '',
                name: '',
                description: '',
                price: 0,
                stock: 0,
                image: ''
            },

            openModal(mode, product = null) {
                this.modalMode = mode;
                if (mode === 'edit' && product) {
                    this.form = { ...product };
                    // Set preview for existing image
                    if (this.form.image) {
                        this.imagePreview = this.form.image.startsWith('http') 
                            ? this.form.image 
                            : `/storage/${this.form.image}`;
                    } else {
                        this.imagePreview = null;
                    }
                } else {
                    this.form = { id: null, category_id: '', name: '', description: '', price: 0, stock: 0, image: '' };
                    this.imagePreview = null;
                }
                this.imageFile = null;
                this.showModal = true;
            },

            handleImageChange(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validation
                if (file.size > 2 * 1024 * 1024) {
                    toast.warning('Image size exceeds 2MB limit.');
                    e.target.value = '';
                    return;
                }

                this.imageFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage() {
                this.imageFile = null;
                this.imagePreview = null;
                this.form.image = '';
                const input = document.getElementById('product-image-input');
                if (input) input.value = '';
            },

            async saveProduct() {
                this.loading = true;
                try {
                    const url = this.modalMode === 'create' ? '/products' : `/products/${this.form.id}`;
                    
                    // Use FormData for file upload
                    const formData = new FormData();
                    formData.append('category_id', this.form.category_id);
                    formData.append('name', this.form.name);
                    formData.append('description', this.form.description);
                    formData.append('price', this.form.price);
                    formData.append('stock', this.form.stock);
                    
                    if (this.imageFile) {
                        formData.append('image', this.imageFile);
                    } else if (this.form.image) {
                        formData.append('image', this.form.image);
                    }

                    // For PUT request with file, we need to spoof method or use POST
                    if (this.modalMode === 'edit') {
                        formData.append('_method', 'PUT');
                        await axios.post(url, formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });
                    } else {
                        await axios.post(url, formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });
                    }

                    window.location.reload();
                } catch (error) {
                    console.error('Save error:', error);
                    toast.error(error.response?.data?.message || 'Something went wrong');
                    this.loading = false;
                }
            },
            async deleteProduct(id) {
                if (!confirm('Are you sure you want to delete this product?')) return;
                
                try {
                    await axios.delete(`/products/${id}`);
                    window.location.reload();
                } catch (error) {
                    toast.error('Cannot delete product. Please try again.');
                }
            }
        }
    }
    </script>
</x-admin-layout>
