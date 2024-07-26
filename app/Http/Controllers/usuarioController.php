<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usuarioController extends Controller
{
    // public function __construct() {
    // }
    public function getUserDataById()
    {
        try {
            $data = json_decode(file_get_contents('php://input'));
            // $results = DB::select('select * from users where id= ?', [1, $data['id']]);
            $user = User::find(auth()->id());
            $results = $user->toArray();

            return json_encode($user);
        } catch (\Exception $e) {
            // Handle the error gracefully
            return response()->json(['error' => 'Error retrieving user data'], 500);
        }
    }
    public function getUserData()
    {
        $results = DB::select('select * from users');
        return json_encode($results);
    }
}
