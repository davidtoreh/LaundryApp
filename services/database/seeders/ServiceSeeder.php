<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'serviceType' => 'Cuci Kering',
                'description' => 'Mencuci dan mengeringkan pakaian',
                'pricePerUnit' => 15000,
                'Unit' => 'Kilogram',
            ],
            [
                'serviceType' => 'Cuci Basah',
                'description' => 'Mencuci dan menjemur pakaian',
                'pricePerUnit' => 12000,
                'Unit' => 'Kilogram',
            ],
            [
                'serviceType' => 'Setrika',
                'description' => 'Menyetrika pakaian',
                'pricePerUnit' => 8000,
                'Unit' => 'Item',
            ],
            [
                'serviceType' => 'Layanan Kilat',
                'description' => 'Layanan cuci dan setrika cepat',
                'pricePerUnit' => 20000,
                'Unit' => 'Kilogram',
            ],
        ]);
    }
}
