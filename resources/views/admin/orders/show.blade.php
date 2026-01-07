<x-admin-layout>
    <x-slot:title>Order Details #{{ $order->order_number }}</x-slot>

    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <a href="/admin/orders" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-slate-400 hover:text-sky-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Order Details</h3>
                </div>
                <p class="text-sm text-slate-500 mt-1 ml-11">Detailed view of transaction and items.</p>
            </div>
            
            <div class="flex items-center gap-3 ml-11 md:ml-0">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] px-4 py-2 rounded-xl 
                    @if($order->status === 'pending') bg-amber-50 text-amber-600 
                    @elseif($order->status === 'processing' || $order->status === 'paid') bg-emerald-50 text-emerald-600 
                    @elseif($order->status === 'failed') bg-rose-50 text-rose-600
                    @else bg-gray-50 text-gray-600 @endif">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Items Ordered</h4>
                    </div>
                    
                    <div class="divide-y divide-gray-50">
                        @foreach($order->orderItems as $item)
                        <div class="px-8 py-6 flex items-center gap-6 group">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($item->product && $item->product->image)
                                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/'.$item->product->image) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <span class="text-[10px] font-black text-sky-600 uppercase tracking-widest mb-1 block">{{ $item->product->category->name ?? 'Category' }}</span>
                                <h5 class="font-bold text-slate-900 text-lg leading-tight">{{ $item->product->name }}</h5>
                                <p class="text-xs text-slate-400 mt-1">Qty: <span class="text-slate-900 font-bold">{{ $item->quantity }}</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-widest">Subtotal: Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="px-8 py-6 bg-slate-900 text-white flex justify-between items-center">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Total Amount</p>
                            <p class="text-2xl font-black">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ count($order->orderItems) }} Items</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Info & Payment -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Customer Info</h4>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-sky-50 flex items-center justify-center text-sky-600 font-black">
                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-slate-400">{{ $order->user->email ?? 'no email' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Shipping Address</p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $order->shipping_address ?? 'No address provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 overflow-hidden relative">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Payment History</h4>
                    
                    @if($order->payment)
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Midtrans Transaction ID</p>
                            <p class="text-xs font-mono font-bold text-slate-600 break-all">{{ $order->payment->transaction_id }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Method</p>
                                <p class="text-xs font-black text-slate-900 uppercase">{{ $order->payment->payment_type }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Time</p>
                                <p class="text-xs font-bold text-slate-900">{{ date('H:i', strtotime($order->payment->transaction_time)) }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round"/></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-600 uppercase tracking-widest">Waiting for Payment</p>
                    </div>
                    @endif
                    
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-gray-50 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
