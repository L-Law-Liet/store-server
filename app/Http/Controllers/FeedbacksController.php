<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return Feedback::where('product_id', $product->id)->with('product', 'user')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedbackRequest $request)
    {
        return Feedback::create($request->validated());
    }


    public function checkAccess(User $user, Product $product){
        return OrderItem::where('product_id', $product->id)
            ->whereIn('order_id', Order::where('user_id', $user->id)->pluck('id'))->get()
                ->count() > Feedback::where('user_id', $user->id)->where('product_id', $product->id)
                ->get()->count();
    }
}
