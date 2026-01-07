<x-layout>
    <div class="pt-32 pb-24 px-6 lg:px-8 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-[3rem] p-12 shadow-2xl shadow-sky-100 text-center border border-gray-100">
            <div class="w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
                <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Payment Pending</h1>
            <p class="text-slate-500 font-medium mb-10 leading-relaxed">
                We are waiting for your payment to be completed. Please follow the instructions in your payment provider.
            </p>
            <div class="space-y-4">
                <a href="/shop" class="block w-full py-4 bg-sky-600 text-white rounded-2xl font-bold hover:bg-sky-700 transition-all shadow-lg shadow-sky-100">
                    Back to Shop
                </a>
                <a href="/" class="block w-full py-4 text-slate-500 font-bold hover:text-sky-600 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</x-layout>
