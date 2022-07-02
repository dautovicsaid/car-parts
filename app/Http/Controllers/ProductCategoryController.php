<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        return ProductCategory::all();
    }

    public function create(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->only('name');
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $productCategory = ProductCategory::create($data);

        return $productCategory;
    }

    public function get($id)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $productCategory = ProductCategory::find($id);

        if (!$productCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product category not found.',
            ], 404);
        }

        return $productCategory;
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->only('name');

        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $productCategory->update($data);

        return $productCategory;
    }

    public function delete(ProductCategory $productCategory)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $productCategory->delete();

        return response()->noContent();
    }
}
