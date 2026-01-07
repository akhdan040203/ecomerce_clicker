<x-layout>
    <div class="pt-32 pb-24 px-6 lg:px-8 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-[3rem] p-12 shadow-2xl shadow-sky-100 text-center border border-gray-100">
            <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Payment Successful!</h1>
            <p class="text-slate-500 font-medium mb-10 leading-relaxed">
                Thank you for your purchase. Your order has been placed and is being processed.
            </p>
            <div class="space-y-4">
                <a href="/shop" class="block w-full py-4 bg-sky-600 text-white rounded-2xl font-bold hover:bg-sky-700 transition-all shadow-lg shadow-sky-100">
                    Continue Shopping
                </a>
                <a href="/" class="block w-full py-4 text-slate-500 font-bold hover:text-sky-600 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</x-layout>
