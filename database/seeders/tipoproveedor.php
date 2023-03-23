<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoProveedor;

class tipoproveedores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoproveedor = TipoProveedor::create([
            'nombre'=>'Persona Natural',
            'descripcion'=>'Persona del común',
        ]);

        $tipoproveedor = TipoProveedor::create([
            'nombre'=>'Persona Jurídica',
            'descripcion'=>'Persona jurídica',
        ]);
    }
}
