<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use App\Models\TipoProveedor;
use App\Models\Tiposcuenta;
use App\Models\Regiman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Sandra',
            'documento' => '43600777',
            'apellido' => 'Gomez Estrada',
            'telefono' => '3002818634',
            'direccion' => 'Carrera 48b # 85 cc 10',
            'email' => 'papascaseraseg@gmail.com',
            'password' => bcrypt('estradagomez230412'),
            'image' => null,
        ]);

        $empleado = new User;
        $empleado->name = 'Jean Paul';
        $empleado->documento = '1017253837';
        $empleado->apellido = 'Estrada Gomez';
        $empleado->telefono = '3022141126';
        $empleado->direccion = 'Carrera 48b # 85 cc 10';
        $empleado->email = 'jean2304paul@gmail.com';
        $empleado->password = bcrypt('12345678');
        $empleado->image = null;
        $empleado->save();

        $empleadoRol = Role::create(['name' => 'Empleado']);

        $permisos = Permission::whereIn('name', [
            'ver-proveedor',
            'editar-usuario',
            'crear-proveedor',
            'ver-insumos',
            'ver-compras',
            'Crear-Compra',
            'ver-venta',
            'crear-venta',
            'ver-cliente',
            'editar-cliente',
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'ver-produccion',
            'crear-produccion',
            'Ver-Menu-Compras',
            'Ver-Menu-Ventas',
            'Ver-Menu-Produccion',
            'Ver-Menu-Reportes',
        ])->get();

        $empleadoRol->syncPermissions($permisos);

        $empleado->assignRole($empleadoRol);

        $rol = Role::create(['name' => 'Administrador']);

        $permisos = Permission::pluck('id', 'id')->all();

        $rol->syncPermissions($permisos);

        $admin->assignRole(['Administrador']);


        // codigod e santi 


        $tipoproveedor = TipoProveedor::create([
            'nombre' => 'Persona Natural',
            'descripcion' => 'Persona del común',
        ]);

        $tipoproveedor = TipoProveedor::create([
            'nombre' => 'Persona Jurídica',
            'descripcion' => 'Persona jurídica',
        ]);
        $tipocliente = TipoCliente::create([
            'Nombre' => 'Persona Natural',

        ]);
        $tipocliente = TipoCliente::create([
            'Nombre' => 'Persona Jurídica',

        ]);
        $tipocuenta = Tiposcuenta::create([
            'nombre' => 'Ahorros',

        ]);
        $tipocuenta = Tiposcuenta::create([
            'nombre' => 'Corriente',

        ]);
        $regimen = Regiman::create([
            'nombre' => 'Simplificado',

        ]);
        $regimen = Regiman::create([
            'nombre' => 'Común',

        ]);
    }
}