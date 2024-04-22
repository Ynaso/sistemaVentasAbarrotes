<?php

namespace Database\Seeders;
use App\Models\Level;
use App\Models\comprobante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        comprobante::insert([
            ['tipo_comprobante' => 'Boleta'],
            ['tipo_comprobante' => 'Factura'],
            
        ]);
    }
}
