<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        return DB::transaction(function () use ($request) {

            $product = Product::where('id', $request->product_id)
                              ->lockForUpdate()
                              ->first();

            if ($product->stock < $request->quantity) {
                return response()->json([
                    'message' => 'Insufficient inventory quantity value.'
                ], 422);
            }

            $product->decrement('stock', $request->quantity);

            $order = Order::create([
                'customer_name' => 'Buyer',
                'total_amount' => $product->price * $request->quantity
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id
            ], 201);
        });
    }
}
