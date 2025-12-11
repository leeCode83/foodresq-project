<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\Food;

class SellerController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:sellers',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|in:BAKERY,RESTAURANT,CAFE,GROCERY,CATERING,DESSERT,FAST_FOOD,OTHER',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric', // In real app, geocode address
            'longitude' => 'required|numeric',
            'operating_hours' => 'required|string', // Simplified for demo, expecting JSON string or handle array
        ]);

        // For demo purposes, handle operating_hours if it's not present or invalid
        $operatingHours = $request->operating_hours ?? '{}';
        if (is_array($operatingHours)) {
            $operatingHours = json_encode($operatingHours);
        }

        if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
        }

        $seller = Seller::create([
            'id' => Str::uuid(),
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude ?? 0,
            'longitude' => $request->longitude ?? 0,
            'operating_hours' => json_decode($operatingHours, true),
        ]);

        // Auto login
        Auth::guard('seller')->login($seller);

        return redirect()->route('seller.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('seller')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('seller.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        $sellers = Seller::paginate(15);
        return response()->json([
            'message' => 'Retrieve all sellers success',
            'data' => $sellers
        ], 200);
    }

    public function show($id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Retrieve seller success',
            'data' => $seller
        ], 200);
    }
    public function dashboard()
    {
        $sellerId = Auth::guard('seller')->id();
        $seller = Seller::find($sellerId);
        
        // Fetch stats
        $totalOrders = Transaction::where('seller_id', $sellerId)->count();
        $todaysEarnings = Transaction::where('seller_id', $sellerId)
            ->whereDate('created_at', now())
            ->where('payment_status', 'success')
            ->sum('total_price');
        $pendingPickups = Transaction::where('seller_id', $sellerId)
            ->where('status', 'PENDING') // Or READY_FOR_PICKUP depending on flow
            ->count();

        // Fetch transactions
        $transactions = Transaction::where('seller_id', $sellerId)
            ->with(['buyer', 'food'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.dashboard', compact('seller','totalOrders', 'todaysEarnings', 'pendingPickups', 'transactions'));

    }
}
