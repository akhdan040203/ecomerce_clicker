<x-layout>
<div x-data="profilePage()" x-init="init()" class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="pt-32 pb-12 px-6 lg:px-8 bg-white border-b border-gray-100">
        <div class="mx-auto max-w-7xl">
            <nav class="flex mb-4 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-sky-600 transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-slate-900 font-bold">My Profile</li>
                </ol>
            </nav>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight sm:text-6xl">User <span class="text-sky-600">Profile</span></h1>
        </div>
    </div>

    <div class="px-6 lg:px-8 py-16">
        <div class="mx-auto max-w-4xl">
            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center items-center py-24">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-sky-600"></div>
            </div>

            <!-- Profile Content -->
            <div x-show="!loading" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Sidebar/Quick Info -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-32 text-center">
                            <div class="w-24 h-24 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-black">
                                <span x-text="user.name ? user.name.charAt(0).toUpperCase() : 'U'"></span>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 mb-1" x-text="user.name"></h2>
                            <p class="text-sm text-gray-500 mb-6" x-text="user.email"></p>
                            
                            <div class="pt-6 border-t border-gray-100 text-left space-y-4">
                                <div class="flex items-center gap-3 text-slate-600">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round"/></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Joined <span x-text="new Date(user.created_at).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100">
                            <form @submit.prevent="updateProfile()" class="space-y-8">
                                <!-- Basic Info -->
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">Personal Information</h3>
                                    <div class="grid grid-cols-1 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Full Name</label>
                                            <input type="text" x-model="form.name" required
                                                   class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Email Address</label>
                                            <input type="email" x-model="form.email" required
                                                   class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Shipping Address</label>
                                            <textarea x-model="form.address" rows="4" 
                                                      placeholder="Enter your complete address for shipping..."
                                                      class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Change -->
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-6 border-b border-gray-50 pb-4 pt-4">Security</h3>
                                    <p class="text-xs text-gray-500 mb-6 font-medium">Leave password fields empty if you don't want to change it.</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">New Password</label>
                                            <input type="password" x-model="form.password"
                                                   class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-900 uppercase tracking-widest ml-1">Confirm New Password</label>
                                            <input type="password" x-model="form.password_confirmation"
                                                   class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-sky-500 transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-6">
                                    <button type="submit" :disabled="saving"
                                            class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-lg shadow-gray-200 flex items-center justify-center gap-3 group">
                                        <span x-text="saving ? 'Saving Changes...' : 'Save Profile Changes'"></span>
                                        <svg x-show="!saving" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function profilePage() {
    return {
        user: {},
        form: {
            name: '',
            email: '',
            address: '',
            password: '',
            password_confirmation: ''
        },
        loading: true,
        saving: false,

        async init() {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }
            await this.fetchProfile();
        },

        async fetchProfile() {
            this.loading = true;
            try {
                const response = await axios.get('/user');
                this.user = response.data.data;
                // Sync form
                this.form.name = this.user.name;
                this.form.email = this.user.email;
                this.form.address = this.user.address || '';
            } catch (error) {
                console.error('Error fetching profile:', error);
                if (error.response && error.response.status === 401) {
                    window.location.href = '/login';
                }
            } finally {
                this.loading = false;
            }
        },

        async updateProfile() {
            this.saving = true;
            try {
                const response = await axios.put('/user/profile', this.form);
                this.user = response.data.data;
                
                // Clear password fields
                this.form.password = '';
                this.form.password_confirmation = '';
                
                // Alert success
                toast.success('Profile updated successfully!');
                
                // Refresh to update navbar
                window.location.reload();
            } catch (error) {
                console.error('Error updating profile:', error);
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    toast.error(Object.values(errors).flat().join(', '));
                } else {
                    toast.error('Failed to update profile. Please try again.');
                }
            } finally {
                this.saving = false;
            }
        }
    }
}
</script>
</x-layout>
