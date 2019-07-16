<?php

namespace App\Http\Controllers\Api;

use App\MenuModality;
use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuModalidadController extends Controller
{
    public function index($modality_id)
    {
        $select = [
            "menu_id"
        ];

        $menusThisModality = MenuModality::select($select)->where("modality_id","=",$modality_id);

        $menus = Menu::whereIn("id",$menusThisModality)->get();

        return response()->json(["data" =>$menus, "code" => 200], 200);
    }
}
