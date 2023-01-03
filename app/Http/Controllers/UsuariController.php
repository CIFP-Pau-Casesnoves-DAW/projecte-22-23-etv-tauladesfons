<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;

class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Usuari::all();
         return response()->json(['status'=>'success', 'result' => $tuples],200);
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
        $usuaris= new Usuari;
        $usuaris->ID_USUARI=$request->ID_USUARI;
        $usuaris->DNI=$request->DNI;
        $usuaris->NOM_COMPLET=$request->NOM_COMPLET;
        $usuaris->CORREU_ELECTRONIC=$request->CORREU_ELECTRONIC;
        $usuaris->CONTRASENYA=$request->CONTRASENYA;
        $usuaris->TELEFON=$request->TELEFON;
        $usuaris->ADMINISTRADOR=$request->ADMINISTRADOR;
        $usuaris->save();
        return response()->json(['status'=>'success','result'=>$usuaris], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $usuaris=Usuari::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $usuaris],200);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'result' => 'No existeix l\'usuari'],404);
        }
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
