<x-layout>
<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-sky-50 to-indigo-50">
    <div class="max-w-md w-full" x-data="registerForm()">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Create Account</h1>
                <p class="text-slate-600 mt-2">Join us today!</p>
            </div>

            <!-- Error Message -->
            <div x-show="errorMessage" 
                 x-transition
                 class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p x-text="errorMessage"></p>
            </div>

            <!-- Register Form -->
            <form @submit.prevent="handleRegister()">
                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Full Name
                    </label>
                    <input type="text" 
                           x-model="form.name"
                           required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                           placeholder="John Doe">
                    <p x-show="errors.name" 
                       x-text="errors.name" 
                       class="text-red-500 text-sm mt-1"></p>
                </div>

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
                <div class="mb-4">
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

                <!-- Password Confirmation -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Confirm Password
                    </label>
                    <input type="password" 
                           x-model="form.password_confirmation"
                           required
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                           placeholder="••••••••">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="loading"
                        class="w-full bg-sky-600 text-white font-semibold py-3 rounded-lg hover:bg-sky-700 transition-colors disabled:bg-sky-300 disabled:cursor-not-allowed">
                    <span x-show="!loading">Create Account</span>
                    <span x-show="loading">Creating account...</span>
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center mt-6 text-slate-600">
                Already have an account? 
                <a href="/login" class="text-sky-600 font-semibold hover:text-sky-700">
                    Login here
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function registerForm() {
    return {
        form: {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        },
        errors: {},
        errorMessage: '',
        loading: false,

        async handleRegister() {
            // Reset errors
            this.errors = {};
            this.errorMessage = '';
            this.loading = true;

            try {
                const response = await axios.post('/register', this.form);
                
                // Save token to localStorage
                localStorage.setItem('auth_token', response.data.data.token);
                
                // Set axios default header
                axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`;
                
                // Redirect to home
                window.location.href = '/';
                
            } catch (error) {
                this.loading = false;
                
                if (error.response?.status === 422) {
                    // Validation errors
                    const errorData = error.response.data.errors || {};
                    
                    // Convert Laravel validation errors to simple object
                    this.errors = {};
                    for (let field in errorData) {
                        this.errors[field] = errorData[field][0]; // Get first error message
                    }
                    
                    this.errorMessage = error.response.data.message || 'Please fix the errors below';
                } else {
                    this.errorMessage = 'An error occurred. Please try again.';
                }
            }
        }
    }
}
</script>
</x-layout>
