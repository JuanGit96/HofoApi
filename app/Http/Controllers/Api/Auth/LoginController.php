<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $camps = $this->validateLogin($request);

        if (!$camps)
        {
            return response()->json(["error" => "Usuario y contraseña son obligatorios", "code" => 400], 200);
        }

        if ($this->attemptLogin($request))
        {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'data' => $user,
                "code" => 200
            ]);
        }
        else
        {
            return response()->json(["error" => "Porfavor verifica que los datos ingresados sean los correctos", "code" => 400], 200);
        }


        //return $this->sendFailedLoginResponse($request);
    }

    public function validateLogin($request)
    {
        $rules = [
            "email" => 'required|string',
            'password' => 'required|string',
        ];

        $messages = [
            'required' => 'Usuario y contraseña son obligatorios',
        ];

        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails())
        {
            return false;
        }

        return true;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
}
