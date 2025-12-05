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
        $validator = Validator::make($request->all(), [
            'buyer_id' => 'required|exists:buyers,id',
            'seller_id' => 'required|exists:sellers,id',
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:CASH,TRANSFER,E_WALLET,CREDIT_CARD',
            'pickup_time' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check food availability
        $food = Food::find($request->food_id);
        if ($food->available_quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient food quantity'], 400);
        }

        $transaction = Transaction::create([
            'id' => Str::uuid(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'buyer_id' => $request->buyer_id,
            'seller_id' => $request->seller_id,
            'food_id' => $request->food_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => 'PENDING',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'pickup_code' => strtoupper(Str::random(6)),
            'pickup_time' => $request->pickup_time,
        ]);

        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ], 201);
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
            // Optionally restore stock if it was paid/reserved? 
            // The requirement didn't specify restoring stock on cancel, only reducing on PAID.
            // I'll stick to the requirement: "saat status transaksi sudah PAID, maka stok makanan yang dipesan juga akan ikut berkurang"
        }

        $transaction->save();

        return response()->json([
            'message' => 'Transaction status updated successfully',
            'data' => $transaction
        ], 200);
    }
}
