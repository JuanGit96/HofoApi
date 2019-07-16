<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2/05/19
 * Time: 09:08 AM
 */

namespace App\Http\Traits;


use App\Campaign;
use App\Client;
use App\Pregon;
use App\MenuModality;

trait RelationTrait
{
    public function saveModalitiesByMenu($modalities,$menu_id)
    {
        $this->deleteModalitiesByMenu($menu_id);

        $arrayModalities = explode("_",$modalities);

        try
        {
            foreach($arrayModalities as $modality)
            {
                if ($modality != "")
                {
                    MenuModality::create([
                        "menu_id" => $menu_id,
                        "modality_id" => $modality
                    ]);
                }
            }
        }
        catch(\Exception $e)
        {
            return false;
        }

        return true;

    }

    public function deleteModalitiesByMenu($menu_id)
    {
        $menuModalities = MenuModality::where("menu_id","=",$menu_id);

        foreach($menuModalities->cursor() as $menuModality)
        {
            $menuModality->delete();
        }
    }
}
