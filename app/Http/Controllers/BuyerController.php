<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BuyerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:buyers',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buyer = Buyer::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Auto login after register
        Auth::guard('buyer')->login($buyer);

        return redirect()->route('food.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('buyer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('food.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('buyer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        $buyers = Buyer::all();
        return response()->json([
            'message' => 'Retrieve all buyers success',
            'data' => $buyers
        ], 200);
    }

    public function show($id)
    {
        $buyer = Buyer::find($id);

        if (!$buyer) {
            return response()->json([
                'message' => 'Buyer not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Retrieve buyer success',
            'data' => $buyer
        ], 200);
    }
    public function orders()
    {
        $buyerId = Auth::guard('buyer')->id();
        $transactions = Transaction::where('buyer_id', $buyerId)
            ->with('food') // Eager load food
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('buyer.orders', compact('transactions'));
    }
}
