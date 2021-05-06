<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return $user->carts()->with(['user', 'product'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $cart = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if ($cart){
            $cart->count += $request->count;
            $cart->save();
        }
        else {
            Cart::create(
                [
                    'count' => $request->count,
                    'product_id' => $request->product_id,
                    'user_id' => $user->id
                ]
            );
        }
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        return Cart::where('user_id', $user->id)
            ->where('product_id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        return Cart::where('user_id', $user->id)
            ->where('product_id', $id)->firstOrFail()->delete();
    }
}
