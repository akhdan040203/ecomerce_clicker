<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Use a transaction to ensure data consistency
        return DB::transaction(function () use ($user, $cartItems, $totalPrice) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $user->address ?? 'Default Address'
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Get Midtrans Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            try {
                $snapToken = $this->midtransService->getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                // Clear cart only after successful order creation and token generation
                Cart::where('user_id', $user->id)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => [
                        'order' => $order,
                        'snap_token' => $snapToken
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate payment token: ' . $e->getMessage()
                ], 500);
            }
        });
    }
}
