<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'experiences';

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
    protected $fillable = ['name', 'image_link', 'width', 'heigth', 'scale_px', 'scale_real', 'width_workspace', 'heigth_workspace', 'coord_x_workspace', 'coord_y_workspace','id_project','n_graos','comprimento_linhas'];
}
