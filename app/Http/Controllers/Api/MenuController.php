<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\FileTrait;
use App\Http\Traits\RelationTrait;
use App\Menu;
use App\MenuModality;
use App\Modality;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class MenuController extends Controller
{
    use FileTrait;

    use RelationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findOrFail($id);

        $menu = Menu::where("user_id","=",$user->id)->get();

        return response()->json(["data" =>$menu, "code" => 200], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "nombre" => "required",
            "descripcion" => "required",
            "precio" => "required",
            "foto" => "required",
            "ingredientes" => "required",
            "utencilios" => "required",
            "modalidades" => "required",
            "user_id" => "required"
        ];

        $messages = [
            "nombre.required" => "El campo nombre es obligatorio",
            "descripcion.required" => "El campo descripcion es obligatorio",
            "precio.required" => "el campo precio es obligatorio",
            "foto.required" => "el campo foto es obligatorio",
            "ingredientes.required" => "El campo de ingredientes es obligatorio",
            "utencilios.required" => "El campo de utencilios es obligatorio",
            "modalidades.required" => "El campo de modalidades es obligatorio",
            "user_id.required" => "Error al capturar el id de usurio en sesión, contacte a los administradores"
        ];

        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails())
        {
            return response()->json(["error" => $v->errors()->first(), "code" => 400], 200);
        }

        $data = $request->all();

        if ($request->has('foto'))
        {
            $name = $this->saveFileBas64($data["nombre"],$data["foto"]);

            if ($name != false)
                $data["foto"] = $name;
            else
                return response()->json(["error" =>"error a subir adjunto del campo 'Foto'", "code" => 400], 200);
        }

        $menu = Menu::create($data);

        $savedMenuModalities = $this->saveModalitiesByMenu($request->modalidades,$menu->id);

        if (!$savedMenuModalities)
            return response()->json(["error" =>"error al guardar modalidades asociadas al menu", "code" => 400], 200);

        return response()->json(["data" => $menu, "code" => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->modalities = $menu->modalities()->get();

        return response()->json(["data" =>$menu, "code" => 200], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $rules = [
            "nombre" => "required",
            "descripcion" => "required",
            "precio" => "required",
            //"foto" => "required",
            "ingredientes" => "required",
            "utencilios" => "required",
            "modalidades" => "required",
            "user_id" => "required"
        ];

        $messages = [
            "nombre.required" => "El campo nombre es obligatorio",
            "descripcion.required" => "El campo descripcion es obligatorio",
            "precio.required" => "el campo precio es obligatorio",
            "foto.required" => "el campo foto es obligatorio",
            "ingredientes.required" => "El campo de ingredientes es obligatorio",
            "utencilios.required" => "El campo de utencilios es obligatorio",
            "modalidades.required" => "El campo de modalidades es obligatorio",
            "user_id.required" => "Error al capturar el id de usurio en sesión, contacte a los administradores"
        ];

        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails())
        {
            return response()->json(["error" => $v->errors()->first(), "code" => 400], 200);
        }

        $data = $request->all();

        if ($request->has('foto'))
        {
            if ($data["foto"] != "" && $data["foto"] != null)
            {
                $name = $this->saveFileBas64($data["nombre"],$data["foto"]);

                if ($name != false)
                    $data["foto"] = $name;
                else
                    return response()->json(["error" =>"error a subir adjunto del campo 'Foto'", "code" => 400], 200);
            }
            else
            {
                $data["foto"] = $menu->foto;
            }

        }
        else
        {
            $data["foto"] = $menu->foto;
        }

        $menu->update($data);

        $savedMenuModalities = $this->saveModalitiesByMenu($request->modalidades,$menu->id);

        if (!$savedMenuModalities)
            return response()->json(["error" =>"error al guardar modalidades asociadas al menu", "code" => 400], 200);

        return response()->json(["data" => $menu, "code" => 201], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return response()->json(204);
    }
}
