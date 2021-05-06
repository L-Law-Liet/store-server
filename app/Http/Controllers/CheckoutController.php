<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function getOrders(User $user){
        return $user->order_items()->with('product')->get();
    }

    public function makeOrder(User $user, Request $request){
        if ($user->bill < $request->total){
            return response('Top up your balance', 409);
        }
        $order = new Order();
        $order->user_id = $user->id;
        $order->total = $request->total;
        $order->save();
        foreach(json_decode($request->cart)??[] as $item){
            $product = Product::findOrFail($item->product_id);
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->count = $item->count;
            $orderItem->cost = $product->price;
            $orderItem->name = $product->name;
            $orderItem->save();
            Cart::findOrFail($item->id)->delete();
        }
        return response()->noContent( 201);
    }
}
