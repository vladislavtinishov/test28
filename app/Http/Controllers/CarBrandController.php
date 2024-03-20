<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        return CarBrand::query()->paginate($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carBrand = $this->getEntity($id);
        return response()->json($carBrand, 201);
    }

    private function getEntity($id)
    {
        $carBrand = CarBrand::query()->find($id);

        if (!$carBrand) {
            throw new NotFoundHttpException('Марка не была найдена');
        }

        return $carBrand;
    }
}
