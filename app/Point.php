<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'points';

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
    protected $fillable = ['coord_x', 'coord_y','id_line'];
}
