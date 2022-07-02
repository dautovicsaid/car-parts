<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        return CarModel::with('brand')->get();
    }

    public function create(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->only('name', 'brand_id');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'brand_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $carModel = CarModel::create($data);

        return $carModel;
    }

    public function get($id)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $carModel = CarModel::with('brand')->get()->find($id);
        if (!$carModel) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, car model not found.',
            ], 404);
        }

        return $carModel;
    }

    public function getCarModelsByBrand($id)
    {
        $carModels = CarModel::where('brand_id', $id)->get();
        return $carModels;
    }

    public function update(Request $request, CarModel $carModel)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->only('name', 'brand_id');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'brand_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 200);
        }

        $carModel->update($data);

        return $carModel;
    }

    public function delete(CarModel $carModel)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $carModel->delete();

        return response()->noContent();
    }
}
