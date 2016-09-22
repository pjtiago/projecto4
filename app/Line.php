<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lines';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['coord_x', 'coord_y', 'angle','id_experience','n_graos_existentes','comprimento_linhas_existentes'];
}
