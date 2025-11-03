<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use App\Upload\Upload;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        $areas = Area::getMainAreas();

        return view('auth.register', compact('areas'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'area_id' => ['required', 'exists:areas,id'],
            'street' => ['required', 'string', 'max:255'],
            'building' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'string', 'max:255'],
            'apartment' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'additional_phone' => ['required', 'string', 'max:255'],
            'main_image' => ['mimes:jpeg,jpg,png,gif','sometimes','max:10000'],
            'agree' => ['required','accepted'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(!empty($data['main_image'])) $image = Upload::uploadImage($data['main_image'], 'users' , $data['name']);


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => $image ?? null,
            'active' => 1
        ]);

        $user->addresses()->create([
            'area_id' => $data['area_id'],
            'street' => $data['street'],
            'building' => $data['building'],
            'floor' => $data['floor'],
            'apartment' => $data['apartment'],
            'postal_code' => $data['postal_code'],
            'phone' => $data['phone'],
            'additional_phone' => $data['additional_phone'],
        ]);

        return $user;
    }
}
