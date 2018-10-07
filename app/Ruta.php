<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'origen', 'destino', 'estado'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    /**
     * The roles that belong to the conductor.
     */
    public function conductores()
    {
        return $this->hasMany('App\Conductor');
    }

}