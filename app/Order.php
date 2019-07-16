<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "diner_name",
        "hour",
        "address",
        "city",
        "phone",
        "date",
        "amount_people",
        "ingredients",
        "utensils",
        "additional_comments",
        "qualification",
        "final_comment",
        "menu_id",
        "diner_id"
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function diner()
    {
        return $this->belongsTo(User::class, 'diner_id');
    }
}
