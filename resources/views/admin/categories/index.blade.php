<x-admin-layout>
    <x-slot:title>Manage Categories</x-slot>

    <div x-data="categoryManagement()" x-init="console.log('Alpine loaded for categories')" class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Categories List</h3>
                <p class="text-sm text-slate-500">Manage your product categories efficiently.</p>
            </div>
            <button @click="openModal('create')" class="bg-sky-600 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-sky-700 transition-all flex items-center gap-2 shadow-lg shadow-sky-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Add Category
            </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-8 py-5">Name</th>
                            <th class="px-8 py-5">Slug</th>
                            <th class="px-8 py-5">Products Count</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($categories as $category)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-800 text-sm">{{ $category->name }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-mono text-slate-400 bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-semibold text-slate-600">{{ $category->products_count ?? $category->products()->count() }} items</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openModal('edit', {{ $category }})" class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                    <button @click="deleteCategory({{ $category->id }})" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($categories->isEmpty())
            <div class="p-20 text-center">
                <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h4 class="font-bold text-slate-800 uppercase tracking-widest text-sm mb-1">No Categories Found</h4>
                <p class="text-xs text-slate-400">Start by adding your first product category.</p>
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
                     class="bg-white rounded-[2.5rem] w-full max-w-lg shadow-2xl overflow-hidden shadow-black/20">
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h4 class="text-lg font-black text-slate-800 uppercase tracking-widest" x-text="modalMode === 'create' ? 'Add New Category' : 'Edit Category'"></h4>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="saveCategory" class="p-10 space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Category Name</label>
                            <input type="text" 
                                   x-model="form.name"
                                   required
                                   autofocus
                                   placeholder="e.g. Mechanical Keyboards"
                                   class="w-full px-6 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-sky-500 rounded-2xl transition-all font-bold text-slate-800">
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showModal = false" class="flex-1 px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-500 bg-gray-100 hover:bg-gray-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="loading"
                                    class="flex-[2] px-6 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-sky-600 transition-all shadow-lg shadow-gray-200 disabled:opacity-50">
                                <span x-show="!loading" x-text="modalMode === 'create' ? 'Create Category' : 'Save Changes'"></span>
                                <span x-show="loading">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
    function categoryManagement() {
        return {
            showModal: false,
            modalMode: 'create',
            loading: false,
            form: {
                id: null,
                name: ''
            },
            openModal(mode, category = null) {
                this.modalMode = mode;
                if (mode === 'edit' && category) {
                    this.form = { id: category.id, name: category.name };
                } else {
                    this.form = { id: null, name: '' };
                }
                this.showModal = true;
            },
            async saveCategory() {
                console.log('saveCategory called', this.form);
                this.loading = true;
                try {
                    const url = this.modalMode === 'create' ? '/categories' : `/categories/${this.form.id}`;
                    const method = this.modalMode === 'create' ? 'post' : 'put';
                    
                    console.log('Sending request:', method, url, this.form);
                    await axios[method](url, this.form);
                    console.log('Success! Reloading...');
                    window.location.reload();
                } catch (error) {
                    console.error('Error saving category:', error);
                    toast.error(error.response?.data?.message || 'Something went wrong');
                    this.loading = false;
                }
            },
            async deleteCategory(id) {
                if (!confirm('Are you sure you want to delete this category? All products under it might be affected.')) return;
                
                try {
                    await axios.delete(`/categories/${id}`);
                    window.location.reload();
                } catch (error) {
                    toast.error('Cannot delete category. Make sure it has no products associated.');
                }
            }
        }
    }
    </script>
</x-admin-layout>
