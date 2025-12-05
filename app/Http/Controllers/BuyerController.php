<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Buyer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
            return response()->json($validator->errors(), 422);
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

        return response()->json([
            'message' => 'Buyer registered successfully',
            'data' => $buyer
        ], 201);
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
}
