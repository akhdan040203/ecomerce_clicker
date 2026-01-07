<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();
        
        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart items retrieved successfully',
            'data' => CartResource::collection($cartItems),
            'meta' => [
                'total_items' => $cartItems->sum('quantity'),
                'total_price' => $totalPrice,
                'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        // Check if item already exists in cart
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cartItem = Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'data' => new CartResource($cartItem->load('product'))
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);
        
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'data' => new CartResource($cartItem->load('product'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully'
        ]);
    }

    /**
     * Clear all cart items.
     */
    public function clear()
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
