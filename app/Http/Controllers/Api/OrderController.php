<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function showByChef($chef_id)
    {
        $user = User::findOrFail($chef_id);

        $menus = $user->menus;

        foreach($menus as $key => $menu)
        {
            $orders[$menu->nombre] = $menu->orders;
        }

        return response()->json(["data" =>$orders, "code" => 200], 200);
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
            "diner_name" => 'required',
            "hour" => 'required',
            "address" => 'required',
            "city" => 'required',
            "phone" => 'required',
            "date" => 'required',
            "menu_id" => 'required'
        ];

        $messages = [
            "diner_name.required" => 'el nombre de comensal es obligatorio',
            "hour.required" => 'la hora de entrega es obligatoria',
            "address.required" => 'la direccion de entrega es obligatoria',
            "city.required" => 'la ciudad de entrega es obligatoria',
            "phone.required" => 'el telefono de entrega es obligatorio',
            "date.required" => 'la fecha de entrega es obligatoria',
            //"date.date" => 'El formato de fecha es incorrecto',
            "menu_id.required" => 'error al capturar identificador de menu'
        ];

        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails())
        {
            return response()->json(["error" => $v->errors()->first(), "code" => 400], 200);
        }

        $data = $request->all();

        $order = Order::create($data);

        return response()->json(["data" => $order, "code" => 201], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $menu = $order->menu;

        $order->menu_name = $menu->nombre;

        return response()->json(["data" =>$order, "code" => 200], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
