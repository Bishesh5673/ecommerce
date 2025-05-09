<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function carts()
    {
        $userId = Auth::id();

        $carts = Cart::with('product.seller')
            ->where('user_id', $userId)
            ->get()
            ->groupBy(function ($cart) {
                return $cart->product->seller->id ?? 'Unknown';
            });

        return view('frontend.carts', compact('carts'));
    }

    public function add_to_cart(Request $request)
    {
        // return $request;
        $product = Product::find($request->product_id);
        if (!$product) {
            return view('frontend.404');
        }

        $cart = new Cart();
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->amount = $product->discount > 0 ? $product->price - ($product->price * $product->discount) * $request->quantity / 100 : $product->price * $request->quantity;
        $cart->save();

        return redirect()->route('carts');
    }

    public function updateQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', Auth::id())
            ->with('product')
            ->first();

        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart not found']);
        }

        $cart->quantity = $request->quantity;
        $product = $cart->product;
        $cart->amount = $product->discount > 0
            ? ($product->price - ($product->price * $product->discount / 100)) * $request->quantity
            : $product->price * $request->quantity;

        $cart->save();

        return response()->json([
            'status' => true,
            'amount' => number_format($cart->amount, 2),
        ]);
    }

    public function deleteCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->route('carts');
    }
}
