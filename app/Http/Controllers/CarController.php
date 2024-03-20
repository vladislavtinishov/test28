<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        return $request->user->cars()
            ->with('model')
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        try {
            $car = new Car($request->toArray());
            $request->user->cars()->save($car);

            return response()->json($car, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Ошибка сохранения: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user;
        $car = $this->getEntity($user, $id);
        return response()->json($car, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, string $id)
    {
        try {
            $user = $request->user;
            $car = $this->getEntity($user, $id);
            $car->car_brand_id = $request->car_brand_id;
            $car->car_model_id = $request->car_model_id;
            $car->year = $request->year;
            $car->mileage = $request->mileage;
            $car->color = $request->color;

            $car->save();

            return response()->json($car, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Ошибка сохранения: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $user = $request->user;
            $car = $this->getEntity($user, $id);
            $car->delete();

            return response()->json(['result' => 'ok'], 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Ошибка сохранения: ' . $e->getMessage()], 500);
        }
    }

    private function getEntity($user, $id)
    {
        $car = $user->cars()->where('id', $id)->first();
        if (!$car) {
            throw new NotFoundHttpException('Машина не была найдена');
        }

        return $car;
    }
}
