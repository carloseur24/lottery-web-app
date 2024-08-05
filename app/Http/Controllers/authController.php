<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class authController extends Controller
{
    //
    public function register()
    {
        return view('authentication.register');
    }
    public function login()
    {
        return view('authentication.login');
    }
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function store()
    /** tasks
     * [] Create database fields related for our requierements
     * [] adapt methods, make them work and create the first user
     */
    {
        try {
            $validation = request()->validate([
                'nombre' => ['required', 'string'],
                'cedula_number' => ['required', 'string', 'unique:users'],
                'phone_number' => ['required', 'string', 'unique:users'],
                'email' => ['email', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ]);

            if (request()->has('password')) {


                $validation['password'] = bcrypt($validation['password']); // Hash the password
                $validation['_token'] = request('_token'); // Hash the password


                $user = User::create($validation);

                Auth::login($user);
                return json_encode(['message' => 'user created successfully']);
                // return redirect('/dashboard');
            } else {
                logger('Password not present'); // Debugging log
                return json_encode(['error' => 'user not created successfully']);
                // return redirect()->back()->withErrors(['password' => 'The password field is required'])->withInput();
            }
        } catch (ValidationException $th) {
            logger()->error('Validation failed:', $th->errors());
            // return ($th->errors());
            return json_encode(['error' => 'user not registered successfully', 'message' => $th->getMessage()]);
        }
    }
    public function authenticate()
    {
        try {
            // $phone = request()->input('phone_number');
            // return json_encode(['message' => 'user authenticated successfully']);

            $atributes = request()->validate([
                'phone_number' => ['required', 'string'],
                'password' => ['required']
            ]);

            if (Auth::attempt($atributes)) {
                request()->session()->regenerate();
                return json_encode(['message' => 'user authenticated successfully']);
            } else {
                return json_encode(['error' => 'user not authenticated successfully']);
            }
            // return redirect('/dashboard');
        } catch (\Throwable $th) {
            return json_encode(['error' => 'user not authenticated successfully', 'message' => $th->getMessage()]);
        }
    }

}
