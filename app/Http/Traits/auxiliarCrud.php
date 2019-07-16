<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 3/05/19
 * Time: 06:31 AM
 */

namespace App\Http\Traits;


trait auxiliarCrud
{

    public function deleteCampNull($request)
    {
        $data = $request->all();

        foreach ($data as $key => $item)
        {
            if ($item == null)
            {
                if ($key == "password")
                {
                    unset($data["password"]);
                    unset($data["password_confirmation"]);
                }
                else
                {
                    unset($data[$key]);
                }
            }

        }

        return $data;
    }

}