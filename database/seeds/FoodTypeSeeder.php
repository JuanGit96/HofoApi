<?php

use App\FoodType;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodType::create([
            'name' => 'Plato fuerte',
        ]);

        FoodType::create([
            'name' => 'Entrada',
        ]);


        FoodType::create([
            'name' => 'Postre',
        ]);
    }
}
