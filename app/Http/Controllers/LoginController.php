<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(Request $request){
        $usuari = Usuari::where('CORREU_ELECTRONIC', $request->input('CORREU_ELECTRONIC'))->first();
        if($usuari && Hash::check($request->input('CONTRASENYA'), $usuari->CONTRASENYA)){
            $apikey = base64_encode(str_random(40));
            $usuari["api_token"]=$apikey;
            $usuari->save();
            return response()->json(['status'=>'Login ok','result'=>$apikey], 200);
        }else{
            return response()->json(['status'=>'Login incorrecte'], 401);
        }
    }

    public function logout(Request $request){
        $usuari = Usuari::where('api_token', $request->input('api_token'))->first();
        if($usuari){
            $usuari["api_token"]=null;
            $usuari->save();
            return response()->json(['status'=>'Logout ok'], 200);
        }else{
            return response()->json(['status'=>'Logout incorrecte'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
