<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompraInsumo
 *
 * @property $id
 * @property $id_compra
 * @property $id_proveedor
 * @property $id_insumo
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Compra $compra
 * @property Insumo $insumo
 * @property Proveedore $proveedore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CompraInsumo extends Model
{
    
    static $rules = [
		'id_compra' => 'required',
		//'id_proveedor' => 'required',
		'id_insumo' => 'required',
		'cantidad' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_compra',/*'id_proveedor'*/'id_insumo','cantidad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function compra()
    {
        return $this->hasOne('App\Models\Compra', 'id', 'id_compra');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function insumo()
    {
        return $this->hasOne('App\Models\Insumo', 'id', 'id_insumo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
   /* public function proveedore()
    {
        return $this->hasOne('App\Models\Proveedore', 'id', 'id_proveedor');
    }*/
    

}
