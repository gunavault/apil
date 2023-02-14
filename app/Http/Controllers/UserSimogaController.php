<?php

namespace App\Http\Controllers;

use App\UserSimoga;
use Illuminate\Http\Request;

class UserSimogaController extends Controller{
    public function loginuser(Request $request)
    {
        $loginReq = UserSimoga::where('username', $request->username)
            ->where('password',md5($request->password))->get();

        return json_encode($loginReq);
    }
}
