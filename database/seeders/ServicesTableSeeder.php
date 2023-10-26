<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the service names
        $serviceNames = [
            'Sangat Puas',
            'Puas',
            'Cukup Puas',
            'Kurang Puas',
            'Tidak Puas',
        ];

        // Loop through the service names and insert them into the "Services" table
        foreach ($serviceNames as $name) {
            Service::create([
                'name' => $name,
            ]);
        }
    }
}
