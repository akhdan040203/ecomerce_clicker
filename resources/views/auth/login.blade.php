<x-layout>
<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-sky-50 to-purple-50">
    <div class="max-w-md w-full" x-data="loginForm()">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Welcome Back!</h1>
                <p class="text-slate-600 mt-2">Login to your account</p>
            </div>

            <!-- Error Message -->
            <div x-show="errorMessage" 
                 x-transition
                 class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p x-text="errorMessage"></p>
            </div>

            <!-- Login Form -->
            <form @submit.prevent="handleLogin()">
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" 
                           x-model="form.email"
                           required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                           placeholder="your@email.com">
                    <p x-show="errors.email" 
                       x-text="errors.email" 
                       class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Password
                    </label>
                    <input type="password" 
                           x-model="form.password"
                           required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                           placeholder="••••••••">
                    <p x-show="errors.password" 
                       x-text="errors.password" 
                       class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="loading"
                        class="w-full bg-sky-600 text-white font-semibold py-3 rounded-lg hover:bg-sky-700 transition-colors disabled:bg-sky-300 disabled:cursor-not-allowed">
                    <span x-show="!loading">Login</span>
                    <span x-show="loading">Logging in...</span>
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center mt-6 text-slate-600">
                Don't have an account? 
                <a href="/register" class="text-sky-600 font-semibold hover:text-sky-700">
                    Register here
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function loginForm() {
    return {
        form: {
            email: '',
            password: ''
        },
        errors: {},
        errorMessage: '',
        loading: false,

        async handleLogin() {
            // Reset errors
            this.errors = {};
            this.errorMessage = '';
            this.loading = true;

            try {
                const response = await axios.post('/login', this.form);
                const user = response.data.data.user;
                
                // Save token to localStorage
                localStorage.setItem('auth_token', response.data.data.token);
                
                // Set axios default header
                axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`;
                
                // Role-based redirection
                if (user.role === 'admin') {
                    window.location.href = '/admin/dashboard';
                } else {
                    window.location.href = '/';
                }
                
            } catch (error) {
                this.loading = false;
                
                if (error.response?.status === 422) {
                    // Validation errors
                    this.errors = error.response.data.errors || {};
                    this.errorMessage = error.response.data.message || 'Validation failed';
                } else if (error.response?.status === 401) {
                    this.errorMessage = 'Invalid email or password';
                } else {
                    this.errorMessage = 'An error occurred. Please try again.';
                }
            }
        }
    }
}
</script>
</x-layout>
