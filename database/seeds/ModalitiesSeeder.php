<?php

use App\Modality;
use Illuminate\Database\Seeder;

class ModalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modality::create([
            'name' => 'Domicilios',
        ]);


        Modality::create([
            'name' => 'Chef en tu casa',
        ]);


        Modality::create([
            'name' => 'Ve a la casa del chef',
        ]);
    }
}
