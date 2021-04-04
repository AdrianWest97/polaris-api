<?php

namespace App\Http\Controllers\Auth;

use App\Models\UsAddress;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{


    use RegistersUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

      public function __construct()
    {
        $this->middleware('guest');
    }

        protected function validator(array $data)
    {
        return Validator::make($data, [
           'fname' => ['required','string'],
            'lname' => ['required','string'],
            'phone' => ['required','string'],
            'id_type' => ['required','string',],
            'id_number' => ['required','string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', "min:8", 'confirmed'],
            'street' => ['required','string'],
            'city' => ['required','string'],
            'parish' => ['required','string'],
            'pickup_id' => ['required','numeric'],
        ]);
    }


     protected function create(array $data)
    {
       $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'id_type' => $data['id_type'],
            'id_number' => $data['id_number'],
            'pickup_id' => $data['pickup_id'],
            'us_address_id' => UsAddress::where('is_default',true)->get()->first()->id,
            'phone' => $data['phone'],
            'password' => Hash::make($data['password'])
        ]);

        $user->address()->create([
            'street' => $data['street'],
            'city' => $data['city'],
            'parish' => $data['parish'],
        ]);

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        return response()->json([
            'token'    => $user->createToken($request->input('device_name'))->accessToken,
            'user'     => $request->user()
        ]);
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect($this->redirectPath());
    }
}