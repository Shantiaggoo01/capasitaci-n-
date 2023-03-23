<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Compra
 *
 * @property $id
 * @property $nFactura
 * @property $id_proveedor
 * @property $id_insumo
 * @property $FechaCompra
 * @property $Total
 * @property $created_at
 * @property $updated_at
 *
 * @property Insumo $insumo
 * @property Proveedore $proveedore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Compra extends Model
{

    static $rules = [
        'nFactura' => 'required',
        'id_proveedor' => 'required',
        'id_insumo' => 'required',
        'FechaCompra' => 'required',
        'Total' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nFactura', 'id_proveedor', 'id_insumo', 'FechaCompra', 'Total', 'user_id'];//<--- agregue user_id para guardar el usuario que creo la compra 


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
    public function proveedore()
    {
        return $this->hasOne('App\Models\Proveedore', 'id', 'id_proveedor');
    }

    public function user() //<--- agregue esto para guardar el usuario que creo la compra 
    {
        return $this->belongsTo(User::class);
    }
}
