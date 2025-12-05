<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'operating_hours' => 'required|array', // Expecting array which will be cast to JSON
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'operating_hours' => $request->operating_hours,
        ]);

        return response()->json([
            'message' => 'Seller registered successfully',
            'data' => $seller
        ], 201);
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
}
