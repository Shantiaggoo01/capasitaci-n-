<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Proveedore
 *
 * @property $id
 * @property $nit
 * @property $nombre
 * @property $direccion
 * @property $telefono
 * @property $banco
 * @property $cuenta
 * @property $idtipo_proveedor
 * @property $created_at
 * @property $updated_at
 *
 * @property TipoProveedor $tipoProveedor
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Proveedore extends Model
{
    
    static $rules = [
		'nit' => 'required',
		'nombre' => 'required',
		'direccion' => 'required',
		'telefono' => 'required',
		'banco' => 'required',
		'cuenta' => 'required',
		'idtipo_proveedor' => 'required',
     //<!-- estado con valor default en 1-->
     'estado' => 'required|in:0,1',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nit','nombre','direccion','telefono','banco','cuenta','idtipo_proveedor','estado'];//<!-- agregue esto para el estado  -->


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoProveedor()
    {
        return $this->hasOne('App\Models\TipoProveedor', 'id', 'idtipo_proveedor');
    }
    public function user() //<--- agregue esto para guardar el usuario que creo la compra 
    {
        return $this->belongsTo(User::class);
    }

}
