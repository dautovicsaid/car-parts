<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        return Brand::all();
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

        $brand = Brand::create($data);

        return response()->json($brand);
    }

    public function get($id)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, brand not found.',
            ], 404);
        }

        return $brand;
    }

    public function update(Request $request, Brand $brand)
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

        $brand->update($data);

        return $brand;
    }

    public function delete(Brand $brand)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $brand->delete();

        return response()->noContent();
    }
}
