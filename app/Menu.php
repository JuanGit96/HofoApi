<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [
        "nombre","descripcion","precio", "foto", "ingredientes" , "utencilios", "user_id"
    ];

    public function modalities()
    {
        return
            $this
                ->belongsToMany('\App\Modality','menu_modality');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
