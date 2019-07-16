<?php namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: lina
 * Date: 28/03/19
 * Time: 18:42
 */

trait registerUserToApi
{

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered($user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }

}