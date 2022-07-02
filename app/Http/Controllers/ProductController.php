<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        return Product::with('productCategory', 'carModel.brand')->get();
    }

    public function create(Request $request)
    {
        $data = $request->only(
            'name',
            'price',
            'min_applicable_year',
            'max_applicable_year',
            'model_id',
            'category_id', );

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'min_applicable_year' => 'required|integer',
            'max_applicable_year' => 'required|integer',
            'model_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $product = Product::create($data);

        return $product;
    }

    public function get($id)
    {
        $product = Product::with('productCategory', 'carModel')->get()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, car model not found.',
            ], 404);
        }

        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->only(
            'name',
            'price',
            'min_applicable_year',
            'max_applicable_year',
            'model_id',
            'category_id', );

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'min_applicable_year' => 'required|integer',
            'max_applicable_year' => 'required|integer',
            'model_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $product->update($data);

        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

}
