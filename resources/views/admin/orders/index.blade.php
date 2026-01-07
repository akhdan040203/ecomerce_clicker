<x-admin-layout>
    <x-slot:title>Manage Orders</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Customer Orders</h3>
            <p class="text-sm text-slate-500">Track and manage all customer transactions.</p>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-8 py-5">Order # / Customer</th>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Amount</th>
                            <th class="px-8 py-5">Payment Method</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $order)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-mono text-xs font-bold text-sky-600 block mb-0.5">#{{ $order->order_number }}</span>
                                <span class="font-bold text-slate-800 text-sm block">{{ $order->user->name ?? 'Guest' }}</span>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $order->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-600">
                                {{ $order->created_at->format('d M Y') }}
                                <div class="text-[10px] text-slate-400">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-black text-slate-900 text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-600 uppercase font-bold text-[10px] tracking-widest text-slate-400">
                                {{ $order->payment->payment_type ?? 'Unpaid' }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg 
                                    @if($order->status === 'pending') bg-amber-50 text-amber-600 
                                    @elseif($order->status === 'processing' || $order->status === 'paid') bg-emerald-50 text-emerald-600 
                                    @elseif($order->status === 'failed') bg-rose-50 text-rose-600
                                    @else bg-gray-50 text-gray-600 @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="/admin/orders/{{ $order->id }}" class="text-xs font-black uppercase tracking-widest text-sky-600 hover:text-sky-700 transition-colors">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-gray-50">
                {{ $orders->links('pagination::tailwind') }}
            </div>

            @if($orders->isEmpty())
            <div class="p-20 text-center">
                <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h4 class="font-bold text-slate-800 uppercase tracking-widest text-sm mb-1">No Orders Found</h4>
                <p class="text-xs text-slate-400">Orders will appear here once customers start checking out.</p>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
