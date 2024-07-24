<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usuarioController extends Controller
{
    // public function __construct() {
    // }
    public function getUserDataById()
    {
        $data = json_decode(file_get_contents('php://input'));
        $results = DB::select('select * from users where id= ?', [1, $data['id']]);
        return json_encode($results);
    }
    public function getUserData()
    {
        $results = DB::select('select * from users');
        return json_encode($results);
    }
}
