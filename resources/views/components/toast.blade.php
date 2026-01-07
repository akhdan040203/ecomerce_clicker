<div x-data="toastManager()" 
     @toast.window="addToast($event.detail)"
     class="fixed top-6 right-6 z-[9999] space-y-3 pointer-events-none">
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             class="pointer-events-auto w-96 max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl border overflow-hidden"
             :class="{
                 'border-green-200': toast.type === 'success',
                 'border-red-200': toast.type === 'error',
                 'border-yellow-200': toast.type === 'warning',
                 'border-blue-200': toast.type === 'info'
             }">
            
            <div class="p-4 flex items-start gap-3">
                <!-- Icon -->
                <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                     :class="{
                         'bg-green-100': toast.type === 'success',
                         'bg-red-100': toast.type === 'error',
                         'bg-yellow-100': toast.type === 'warning',
                         'bg-blue-100': toast.type === 'info'
                     }">
                    <!-- Success Icon -->
                    <svg x-show="toast.type === 'success'" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <!-- Error Icon -->
                    <svg x-show="toast.type === 'error'" class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <!-- Warning Icon -->
                    <svg x-show="toast.type === 'warning'" class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <!-- Info Icon -->
                    <svg x-show="toast.type === 'info'" class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 mb-0.5" x-text="toast.title"></p>
                    <p class="text-xs text-slate-600" x-text="toast.message"></p>
                </div>

                <!-- Close Button -->
                <button @click="removeToast(toast.id)" 
                        class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="h-1 bg-gray-100">
                <div class="h-full transition-all ease-linear"
                     :class="{
                         'bg-green-500': toast.type === 'success',
                         'bg-red-500': toast.type === 'error',
                         'bg-yellow-500': toast.type === 'warning',
                         'bg-blue-500': toast.type === 'info'
                     }"
                     :style="`width: ${toast.progress}%; transition-duration: ${toast.duration}ms`"></div>
            </div>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        nextId: 1,

        addToast(config) {
            const toast = {
                id: this.nextId++,
                type: config.type || 'info',
                title: config.title || this.getDefaultTitle(config.type),
                message: config.message || '',
                duration: config.duration || 3000,
                show: false,
                progress: 100
            };

            this.toasts.push(toast);

            // Trigger show animation
            this.$nextTick(() => {
                toast.show = true;
                
                // Start progress bar animation
                setTimeout(() => {
                    toast.progress = 0;
                }, 50);

                // Auto remove
                setTimeout(() => {
                    this.removeToast(toast.id);
                }, toast.duration);
            });

            // Limit to 5 toasts
            if (this.toasts.length > 5) {
                this.removeToast(this.toasts[0].id);
            }
        },

        removeToast(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) {
                toast.show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        },

        getDefaultTitle(type) {
            const titles = {
                success: 'Success!',
                error: 'Error!',
                warning: 'Warning!',
                info: 'Info'
            };
            return titles[type] || 'Notification';
        }
    }
}
</script>
