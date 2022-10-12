<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index(){
      return response()->json([
          'status'  => true,
          'message' => "berhasil"
      ], 200);
    }

    public function login(Request $req){
        $req->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        try {
            $user = User::where('email',$req->email)->first();
            if(!$user) return response([
                'status'    => false,
                'message'   => 'User tidak ditemukan!'
            ]);
            if(Hash::check($req->password,$user->password)){
                $token = $user->createToken($user->name)->accessToken;
                return response([
                    'status'    => true,
                    'message'   => [
                        'user'  => $user->name,
                        'token' => $token
                    ]
                ]);
            }else{
                return response([
                    'status'    => false,
                    'message'   => 'Login Gagal'
                ]);
            }
        } catch (\Exception $e) {
            return response([
                'status'    => false,
                'message'   => $e->getMessage()
            ]);
        }
    }
}
