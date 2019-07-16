<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\registerUserToApi;
use App\Http\Traits\FileTrait;
use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use registerUserToApi;

    use FileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        return response()->json(["data" => $user, "code" => 201],201);
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            //'calification' => 'required',
            'address' => 'required',
            //'description' => 'required',
            'city' => 'required',
            //'age_experience' => 'required',
            //'photo_home' => 'required',
            'photo_perfil' => 'required',
            'role_id' => 'required',
            'password' =>'required|min:6|confirmed',
            'FMCToken' => 'required'
        ];

        if($request->all()["role_id"] == "1")
        {
            $rules["description"] = "required";
            $rules["age_experience"] = "required";
            $rules["photo_home"] = "required";
        }

        $messages = [
            'name.required' => 'El campo nombre es obligatorio',
            'phone.required' => 'El campo telefono es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'address.required' => 'El campo direccion es obligatorio',
            'description.required' => 'El campo descripcion es obligatorio',
            'city.required' => 'El campo ciudad es obligatorio',
            'age_experience.required' => 'El campo años de experiencia es obligatorio',
            'photo_home.required' => 'la foto de casa es obligatoria',
            'photo_perfil.required' => 'La foto de perfil es obligatoria',
            'role_id.required' => 'No se ha capturado el rol',
            'password.required' => 'El campo contraseña es obligatorio',
            'dateBirth.date' => 'La fecha enviada no tiene el formato correcto',
            'dateBirth.required' => 'el campo fecha de nacimiento es obligatorio',
            'phone.date' => 'EL telefono celular es obligatorio',
            'email' => 'El campo de correo electronico no tiene el formato correcto',
            'unique' => 'El :attribute que enviaste ya está registrado en nuestra plataforma, porfavor inicia sesion',
            'password.min' => 'La contraseña debe tener como minimo 6 caracteres o numeros',
            'confirmed' => 'Las contraseñas no coinciden',
            'FMCToken.required' => 'error al capturar toquen de telefono'
        ];

        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails())
        {
            return response()->json(["error" => $v->errors()->first(), "code" => 400], 200);
        }

        $data = $request->all();

        if ($request->has('photo_perfil'))
        {
            $name = $this->saveFileBas64($data["name"],$data["photo_perfil"]);

            if ($name != false)
                $data["photo_perfil"] = $name;
            else
                return response()->json(["error" =>"error a subir adjunto del campo 'Foto'", "code" => 400], 200);
        }

        if ($request->has('photo_home'))
        {
            $name = $this->saveFileBas64($data["name"],$data["photo_home"]);

            if ($name != false)
                $data["photo_home"] = $name;
            else
                return response()->json(["error" =>"error a subir adjunto del campo 'video'", "code" => 400], 200);
        }


        $data["password"] = bcrypt($data["password"]);

        $user = User::create($data);

        $this->guard()->login($user);

        $this->registered($user);


        return response()->json(["data" => $user, "code" => 201], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(["data" =>$user, "code" => 200], 200);
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
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' =>'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->dateBirth = $request->dateBirth;
        $user->email = $request->email;

        if(!$user->isDirty())
        {
            return response()->json(["error" => 'se debe especificar al menos un valor diferente para actualizar', "code" => 422],422);
        }

        $user->save();


        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idaa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(204);
    }



}
