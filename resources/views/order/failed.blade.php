<x-layout>
    <div class="pt-32 pb-24 px-6 lg:px-8 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-[3rem] p-12 shadow-2xl shadow-rose-100 text-center border border-gray-100">
            <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Payment Failed</h1>
            <p class="text-slate-500 font-medium mb-10 leading-relaxed">
                Something went wrong with your transaction. Please try again later or use a different payment method.
            </p>
            <div class="space-y-4">
                <a href="/cart" class="block w-full py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-100">
                    Back to Cart
                </a>
                <a href="/shop" class="block w-full py-4 text-slate-500 font-bold hover:text-sky-600 transition-colors">
                    Back to Shop
                </a>
            </div>
        </div>
    </div>
</x-layout>
