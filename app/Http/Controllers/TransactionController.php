<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\Food;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        $buyerId = \Illuminate\Support\Facades\Auth::guard('buyer')->id(); // Assuming logged in buyer

        if (!$buyerId) {
             return redirect()->route('auth.buyer')->with('error', 'Please login first!');
        }

        foreach ($cart as $id => $details) {
            // Check food availability
            $food = Food::find($id);
            if ($food->available_quantity < $details['quantity']) {
                return redirect()->back()->with('error', 'Insufficient quantity for ' . $details['title']);
            }

            Transaction::create([
                'id' => Str::uuid(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'buyer_id' => $buyerId,
                'seller_id' => $details['seller_id'],
                'food_id' => $id,
                'quantity' => $details['quantity'],
                'total_price' => $details['price'] * $details['quantity'],
                'status' => 'PENDING', // Or PAID depending on payment flow simulation
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'pickup_code' => strtoupper(Str::random(6)),
                'pickup_time' => now()->addHours(1), // Default pickup time
            ]);
        }

        session()->forget('cart');

        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully!');
    }

    public function getByBuyer($buyerId)
    {
        $transactions = Transaction::where('buyer_id', $buyerId)->paginate(10);
        return response()->json([
            'message' => 'Retrieve buyer transactions success',
            'data' => $transactions
        ], 200);
    }

    public function getBySeller($sellerId)
    {
        $transactions = Transaction::where('seller_id', $sellerId)->paginate(10);
        return response()->json([
            'message' => 'Retrieve seller transactions success',
            'data' => $transactions
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:PENDING,PAID,READY_FOR_PICKUP,COMPLETED,CANCELLED',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $oldStatus = $transaction->status;
        $newStatus = $request->status;

        $transaction->status = $newStatus;

        if ($newStatus === 'PAID' && $oldStatus !== 'PAID') {
            $transaction->paid_at = Carbon::now();
            $transaction->payment_status = 'success';

            // Reduce stock
            $food = Food::find($transaction->food_id);
            if ($food) {
                $food->available_quantity -= $transaction->quantity;
                $food->save();
            }
        }

        if ($newStatus === 'COMPLETED') {
            $transaction->completed_at = Carbon::now();
        }

        if ($newStatus === 'CANCELLED') {
            $transaction->cancelled_at = Carbon::now();
        }

        $transaction->save();

        return response()->json([
            'message' => 'Transaction status updated successfully',
            'data' => $transaction
        ], 200);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|string',
        ]);

        $transaction = Transaction::where('pickup_code', $request->pickup_code)
            ->where('status', '!=', 'COMPLETED')
            ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Invalid or already completed pickup code.');
        }

        // Update status to COMPLETED
        $transaction->status = 'COMPLETED';
        $transaction->completed_at = now();
        $transaction->payment_status = 'success'; // Ensure payment is marked success if not already
        $transaction->save();

        if ($transaction->payment_method == 'CASH') {
             $food = Food::find($transaction->food_id);
             if ($food) {
                 $food->available_quantity -= $transaction->quantity;
                 $food->save();
             }
        }

        return redirect()->back()->with('success', 'Transaction verified and completed successfully!');
    }
}
