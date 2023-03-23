<?php

namespace Database\Seeders;

use CreatePermissionTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class SeederTablePermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [

            // tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            // tabla proveedores
            'ver-proveedor',
            'crear-proveedor',
            'editar-proveedor',
            'borrar-proveedor',


            // tabla cliente
            'ver-cliente',
            'editar-cliente',
            'crear-cliente',
            'borrar-cliente',


            // tabla compras
            'Crear-Compra',

            // tabla insumos
            'ver-insumos',
            'editar-insumos',
            'crear-insumos',
            'borrar-insumos',


            // tabla producto
            'ver-producto',
            'editar-producto',
            'crear-producto',
            'borrar-producto',


            // tabla roles
            'ver-roles',
            'editar-roles',
            'crear-roles',
            'borrar-roles',

            // Tabla botones
            'Ver-Menu-Configuracion',
            'Ver-Menu-Compras',
            'Ver-Menu-Ventas',
            'Ver-Menu-Produccion',
            'Ver-Menu-Reportes',
            'cambiar-estado',
            'asignar-roles',

            // tabla usuarios
            'ver-usuario',
            'editar-usuario',
            'crear-usuario',
            'borrar-usuario',

            'ver-compras',


            // tabla venta
            'ver-venta',
            'editar-venta',
            'crear-venta',
            'borrar-venta',

            // Tabla Produccion
            'crear-produccion',
            'editar-produccion',
            'eliminar-produccion',
            'ver-produccion',




        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
