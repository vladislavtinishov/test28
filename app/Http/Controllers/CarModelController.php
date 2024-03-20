<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        return CarModel::query()
            ->with('cars')
            ->with('brand')
            ->paginate($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carModel = $this->getEntity($id);
        return response()->json($carModel, 201);
    }

    private function getEntity($id)
    {
        $carModel = CarModel::query()->find($id);

        if (!$carModel) {
            throw new NotFoundHttpException('Модель не была найдена');
        }

        return $carModel;
    }
}
