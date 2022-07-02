<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function addToCart(Request $request, $id)
    {
        $data = $request->only('quantity');
        $validator = Validator::make($data, [
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $userId = auth()->id();

        $order = Order::where('user_id', $userId)->whereNull('ordered_at')->first();
        if ($order == null) {
            $order = Order::create([
                'user_id' => $userId,
            ]);
        }

        $data['product_id'] = $id;
        $data['order_id'] = $order->id;
        $orderItem = OrderItem::create($data);

        return $orderItem;
    }

    public function completeOrder(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($order->isCompleted()) {
            return response()->json(['error' => 'Order is already completed'], 400);
        }

        $totalPrice = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.order_id', $order->id)
            ->sum(DB::raw('order_items.quantity * products.price'));

        $order->total_price = $totalPrice;
        $order->ordered_at = now();
        $order->save();

        return $order;

    }

    public function getCart()
    {
        $order = Order::where('user_id', auth()->id())->whereNull('ordered_at')->first();
        if ($order == null) {
            return [];
        }

        $orderItems = OrderItem::where('order_id', $order->id)
            ->with('product.carModel.brand', 'product.productCategory')
            ->get();

        return $orderItems;
    }

    public function updateOrderItem(Request $request, Order $order, OrderItem $orderItem)
    {
        if ($order->user_id != auth()->id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($order->isCompleted()) {
            return response()->json(['error' => 'Order is completed'], 400);
        }

        $data = $request->only('quantity');
        $validator = Validator::make($data, [
            'quantity' => 'required|integer|min:0|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $orderItem->quantity = $data['quantity'];
        $orderItem->save();

        return $orderItem;

    }

    public function deleteOrderItem(Order $order, Orderitem $orderItem)
    {
        if ($order->isCompleted()) {
            return response()->json(['error' => 'Order is completed'], 400);
        }

        $orderItem->delete();

        return response()->noContent();
    }

    public function getAuthUserOrders()
    {
        return Order::where('user_id', 1)->whereNotNull('ordered_at')->get();
    }
}
