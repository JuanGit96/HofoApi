<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuModality extends Model
{
    protected $table = "menu_modality";

    protected $fillable = [
            "menu_id", "modality_id"
    ];
}
