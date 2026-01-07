<div x-data="confirmDialog()" 
     @confirm.window="show($event.detail)"
     x-show="visible"
     x-cloak
     class="fixed inset-0 z-[10000] flex items-center justify-center"
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="cancel()"
         class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <!-- Dialog -->
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        
        <!-- Header -->
        <div class="p-6 pb-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-xl font-black text-slate-900 mb-2" x-text="title"></h3>
                    <p class="text-sm text-slate-600 leading-relaxed" x-text="message"></p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="px-6 pb-6 flex gap-3">
            <button @click="cancel()" 
                    class="flex-1 px-6 py-3 bg-gray-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all active:scale-95">
                Cancel
            </button>
            <button @click="confirm()" 
                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 transition-all shadow-lg shadow-red-200 active:scale-95">
                <span x-text="confirmText"></span>
            </button>
        </div>
    </div>
</div>

<script>
function confirmDialog() {
    return {
        visible: false,
        title: '',
        message: '',
        confirmText: 'OK',

        init() {
            // Listen for confirm requests
            window.addEventListener('confirm', (e) => {
                this.show(e.detail);
            });
        },

        show(config) {
            this.title = config.title || 'Confirm Action';
            this.message = config.message || 'Are you sure?';
            this.confirmText = config.confirmText || 'OK';
            this.visible = true;
        },

        confirm() {
            this.visible = false;
            window.dispatchEvent(new CustomEvent('confirm-response', {
                detail: { confirmed: true }
            }));
        },

        cancel() {
            this.visible = false;
            window.dispatchEvent(new CustomEvent('confirm-response', {
                detail: { confirmed: false }
            }));
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
