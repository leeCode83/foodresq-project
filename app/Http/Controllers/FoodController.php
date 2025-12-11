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
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Food created successfully',
                'data' => $food
            ], 201);
        }

        return redirect()->route('seller.foods.index')->with('success', 'Food created successfully');
    }

    public function destroy(Request $request, $id)
    {
        $food = Food::find($id);

        if (!$food) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Food not found'], 404);
            }
            return redirect()->back()->with('error', 'Food not found');
        }

        $food->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Food deleted successfully'], 200);
        }

        return redirect()->route('seller.foods.index')->with('success', 'Food deleted successfully');
    }

    public function index()
    {
        $foods = Food::where('available_quantity', '>', 0)->get();
        return view('food.index', compact('foods'));
    }

    public function sellerIndex()
    {
        $sellerId = auth('seller')->id();
        $foods = Food::where('seller_id', $sellerId)->orderBy('created_at', 'desc')->paginate(10);
        return view('seller.foods.index', compact('foods'));
    }

    public function getBySeller($sellerId)
    {
        $foods = Food::where('seller_id', $sellerId)->paginate(10);
        return response()->json([
            'message' => 'Retrieve foods by seller success',
            'data' => $foods
        ], 200);
    }

    public function getByCategory(Request $request, $category)
    {
        $foods = Food::where('category', strtoupper($category))
                     ->where('available_quantity', '>', 0)
                     ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Retrieve foods by category success',
                'data' => $foods
            ], 200);
        }

        return view('food.index', compact('foods'));
    }

    public function show($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return redirect()->route('food.index')->with('error', 'Food not found');
        }

        return view('food.detail', compact('food'));
    }

    public function edit($id)
    {
        $food = Food::find($id);
        
        if (!$food) {
            return redirect()->route('seller.foods.index')->with('error', 'Food not found');
        }

        // Check ownership
        if ($food->seller_id !== auth('seller')->id()) {
             return redirect()->route('seller.foods.index')->with('error', 'Unauthorized');
        }

        return view('seller.foods.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $food = Food::find($id);

        if (!$food) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Food not found'], 404);
            }
            return redirect()->back()->with('error', 'Food not found');
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
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $food->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Food updated successfully',
                'data' => $food
            ], 200);
        }

        return redirect()->route('seller.foods.index')->with('success', 'Food updated successfully');
    }
}
