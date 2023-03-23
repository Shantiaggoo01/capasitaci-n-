<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $idTipoCliente
 * @property $Nombre
 * @property $Apellido
 * @property $Telefono
 * @property $Direccion
 * @property $NIT
 * @property $created_at
 * @property $updated_at
 *
 * @property Tipocliente $tipocliente
 * @property Venta[] $ventas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    static $rules = [
		'idTipoCliente' => 'required',
		'Nombre' => 'required',
		'Apellido' => 'required',
		'Telefono' => 'required',
		'Direccion' => 'required',
		'NIT' => 'required',
        'Estado' => 'in:0,1',
    
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idTipoCliente','Nombre','Apellido','Telefono','Direccion','NIT','Estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipocliente()
    {
        return $this->hasOne('App\Models\Tipocliente', 'id', 'idTipoCliente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventas()
    {
        return $this->hasMany('App\Models\Venta', 'idCliente', 'id');
    }
    

}
