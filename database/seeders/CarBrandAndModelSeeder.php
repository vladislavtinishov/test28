<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarBrandAndModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Создание брендов автомобилей
        CarBrand::create(['name' => 'Toyota']);
        CarBrand::create(['name' => 'Ford']);
        CarBrand::create(['name' => 'Honda']);

        // Создание моделей автомобилей
        CarModel::create(['name' => 'Corolla', 'car_brand_id' => 1]); // Toyota
        CarModel::create(['name' => 'Camry', 'car_brand_id' => 1]);   // Toyota
        CarModel::create(['name' => 'Mustang', 'car_brand_id' => 2]); // Ford
        CarModel::create(['name' => 'Civic', 'car_brand_id' => 3]);   // Honda
    }
}
