<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderNumber = $notification->order_id;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->status = 'pending';
                    } else {
                        $order->status = 'processing';
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->status = 'processing';
            } elseif ($transactionStatus == 'pending') {
                $order->status = 'pending';
            } elseif ($transactionStatus == 'deny') {
                $order->status = 'failed';
            } elseif ($transactionStatus == 'expire') {
                $order->status = 'failed';
            } elseif ($transactionStatus == 'cancel') {
                $order->status = 'failed';
            }

            $order->save();

            // Reduce stock automatically when payment is successful
            if ($order->status === 'processing') {
                $order->load('orderItems.product');
                
                foreach ($order->orderItems as $item) {
                    if ($item->product) {
                        $product = $item->product;
                        $newStock = $product->stock - $item->quantity;
                        
                        // Prevent negative stock
                        if ($newStock < 0) {
                            $newStock = 0;
                        }
                        
                        $product->stock = $newStock;
                        $product->save();
                        
                        Log::info("Stock reduced for product {$product->name}: {$item->quantity} units. New stock: {$newStock}");
                    }
                }
            }

            // Update or Create Payment record
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $notification->transaction_id,
                    'payment_type' => $type,
                    'status' => $transactionStatus,
                    'transaction_time' => $notification->transaction_time,
                ]
            );

            return response()->json(['message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Callback error'], 500);
        }
    }
}
