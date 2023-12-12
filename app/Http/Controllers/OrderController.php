<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // public function getAllOrders()
    // {
    //     // $orders = Order::with('user', 'products')->get();
    //     $orders = Order::with('user', 'products:id,name,description,price')->get();

    //     return response()->json($orders);
    // }

    public function getAllOrders()
{
    $orders = Order::with(['user' => function ($query) {
        $query->select('id', 'email');
    }, 'products'])->get();

    return response()->json($orders);
}

    public function show($id)
    {
        $order = Order::with('user', 'products')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function createOrder(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ]);

        // Create the order
        $order = Order::create([
            'user_id' => $validatedData['user_id'],
            'shipping_address' => $validatedData['shipping_address'],
        ]);

        // Attach products to the order
        foreach ($validatedData['order_items'] as $item) {
            $order->products()->attach($item['product_id'], ['quantity' => $item['quantity']]);
        }

        // Fetch the created order with associated products
        $orderWithProducts = Order::with('user', 'products')->find($order->id);

        return response()->json($orderWithProducts, 201);
    }

   

    // public function updateOrder(Request $request, $id)
    // {
    //     $order = Order::find($id);

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'exists:users,id',
    //         'shipping_address' => 'required',
    //         // Add other validation rules as needed
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $order->update([
    //         'user_id' => $request->input('user_id', $order->user_id),
    //         'shipping_address' => $request->input('shipping_address', $order->shipping_address),
    //         // Add other fields as needed
    //     ]);

    //     // Sync products with the order (assuming 'product_ids' is an array of product IDs in the request)
    //     $order->products()->sync($request->input('product_ids'));

    //     return response()->json(['message' => 'Order Updated Successfully']);
    // }

    public function updateOrder(Request $request, $id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $validator = Validator::make($request->all(), [
        'user_id' => 'exists:users,id',
        'shipping_address' => 'required',
        // Add other validation rules as needed
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $order->update([
        'user_id' => $request->input('user_id', $order->user_id),
        'shipping_address' => $request->input('shipping_address', $order->shipping_address),
        // Add other fields as needed
    ]);

    // Update products only if 'product_ids' are provided in the request
    if ($request->has('product_ids')) {
        // Sync products with the order
        $order->products()->sync($request->input('product_ids'));
    }

    return response()->json(['message' => 'Order Updated Successfully']);
}


    public function deleteOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function getOrderById($id)
        {
            $order = Order::findOrFail($id);
            return response()->json(['status'=>true, 'Order' => $order]);
        }
}
