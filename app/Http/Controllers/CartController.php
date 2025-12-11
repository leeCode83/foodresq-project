<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $buyerId = Auth::guard('buyer')->id();

        if (!$buyerId) {
            return redirect()->route('auth.buyer');
        }

        $food = Food::find($id);

        if (!$food) {
            return redirect()->back()->with('error', 'Food not found!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $food->id,
                'title' => $food->title,
                'quantity' => 1,
                'price' => $food->discounted_price,
                'image' => $food->image_url,
                'seller_id' => $food->seller_id
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Food added to cart successfully!');
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Food removed successfully');
        }
    }
}
