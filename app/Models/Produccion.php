<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Produccion
 *
 * @property $id
 * @property $fecha_producción
 * @property $cantidad
 * @property $fecha_vencimiento
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Produccion extends Model
{
    
    static $rules = [
		'fecha_producción' => 'required',
		'cantidad' => 'required',
		'fecha_vencimiento' => 'required',
    ];

    protected $perPage = 20;

    protected $table = 'produccion';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fecha_producción','cantidad','fecha_vencimiento'];

    



}
