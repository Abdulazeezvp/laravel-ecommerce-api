<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $orders = Order::with('items.product')->get();
            return response()->json($orders, 200);
        }

        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($orders, 200);
    }
    public function show($id)
    {
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (auth()->user()->isAdmin() || auth()->id() === $order->user_id) {
            return response()->json($order, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function store(Request $request)
    {
        if (auth()->user()->isCustomer()) {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            $totalPrice = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $totalPrice += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            return response()->json($order->load('items'), 201);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (auth()->user()->isAdmin() || auth()->id() === $order->user_id) {
            $validated = $request->validate([
                'status' => 'required|string',
            ]);

            if (auth()->user()->isAdmin()) {
                $order->status = $validated['status'];
            }

            $order->save();

            return response()->json($order, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
    
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (auth()->user()->isAdmin() || auth()->id() === $order->user_id) {
            $order->delete();
            return response()->json(['message' => 'Order deleted'], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
