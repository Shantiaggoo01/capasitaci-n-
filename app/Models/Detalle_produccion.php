<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_produccion extends Model
{
    use HasFactory;
    static $rules = [
        'id_produccion' => 'required',
        'id_producto' => 'required',
        'cantidad' => 'required',
    ];
    protected $table = 'detalle_produccion';
    protected $fillable = ['id_produccion','id_producto','cantidad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function produccion()
    {
        return $this->hasOne('App\Models\Produccion', 'id', 'id_produccion');
    }
    

}
