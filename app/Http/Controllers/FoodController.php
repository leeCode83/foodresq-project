<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Food;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:BAKERY,RESTAURANT,CAFE,GROCERY,CATERING,DESSERT,FAST_FOOD,OTHER',
            'image_url' => 'required|string',
            'original_price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'discount_percentage' => 'required|integer',
            'quantity' => 'required|integer',
            'available_quantity' => 'required|integer',
            'pickup_time_start' => 'required|date',
            'pickup_time_end' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $food = Food::create([
            'id' => Str::uuid(),
            'seller_id' => $request->seller_id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image_url' => $request->image_url,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'discount_percentage' => $request->discount_percentage,
            'quantity' => $request->quantity,
            'available_quantity' => $request->available_quantity,
            'pickup_time_start' => $request->pickup_time_start,
            'pickup_time_end' => $request->pickup_time_end,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Food created successfully',
            'data' => $food
        ], 201);
    }

    public function destroy($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        $food->delete();

        return response()->json(['message' => 'Food deleted successfully'], 200);
    }

    public function index()
    {
        $foods = Food::paginate(10);
        return response()->json([
            'message' => 'Retrieve all foods success',
            'data' => $foods
        ], 200);
    }

    public function getBySeller($sellerId)
    {
        $foods = Food::where('seller_id', $sellerId)->paginate(10);
        return response()->json([
            'message' => 'Retrieve foods by seller success',
            'data' => $foods
        ], 200);
    }

    public function getByCategory($category)
    {
        $foods = Food::where('category', $category)->paginate(10);
        return response()->json([
            'message' => 'Retrieve foods by category success',
            'data' => $foods
        ], 200);
    }

    public function show($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        return response()->json([
            'message' => 'Retrieve food success',
            'data' => $food
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'category' => 'in:BAKERY,RESTAURANT,CAFE,GROCERY,CATERING,DESSERT,FAST_FOOD,OTHER',
            'image_url' => 'string',
            'original_price' => 'numeric',
            'discounted_price' => 'numeric',
            'discount_percentage' => 'integer',
            'quantity' => 'integer',
            'available_quantity' => 'integer',
            'pickup_time_start' => 'date',
            'pickup_time_end' => 'date',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $food->update($request->all());

        return response()->json([
            'message' => 'Food updated successfully',
            'data' => $food
        ], 200);
    }
}
