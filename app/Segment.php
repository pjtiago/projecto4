<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'segments';

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
    protected $fillable = ['id_line','id_material','id_start_point','id_final_point','comprimento_segmento'];
}
