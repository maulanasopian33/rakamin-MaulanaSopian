<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
