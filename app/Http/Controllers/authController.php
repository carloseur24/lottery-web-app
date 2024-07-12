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
        return view('register');
    }
    public function login()
    {
        return view('login');
    }
    public function logout()
    {
        return view('logout');
    }

    public function store()
    /** tasks
     * [] Create database fields related for our requierements
     * [] adapt methods, make them work and create the first user
     */
    {
        try {
            $validation = request()->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ]);
            if (request()->has('password')) {


                $validation['password'] = bcrypt($validation['password']); // Hash the password
                $validation['role'] = 'admin'; // Hash the password
                $validation['_token'] = request('_token'); // Hash the password


                $user = User::create($validation);

                Auth::login($user);
                return redirect('/dashboard');
            } else {
                logger('Password not present'); // Debugging log
                return redirect()->back()->withErrors(['password' => 'The password field is required'])->withInput();
            }
        } catch (ValidationException $th) {
            logger()->error('Validation failed:', $th->errors());
            return ($th->errors());
        }
    }
    public function authenticate()
    {
        try {
            $atributes = request()->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);
            Auth::attempt($atributes);

            request()->session()->regenerate();

            return redirect('/dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
