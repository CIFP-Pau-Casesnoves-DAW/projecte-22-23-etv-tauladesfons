<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Traduccio_serveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Traduccio_servei::all();
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
        $traduccio_servei= new Traduccio_servei;
        $traduccio_servei->FK_ID_SERVEI=$request->FK_ID_SERVEI;
        $traduccio_servei->FK_ID_IDIOMA=$request->FK_ID_IDIOMA;
        $traduccio_servei->TRADUCCIO_SERVEI=$request->TRADUCCIO_SERVEI;
        $traduccio_servei->save();
        return response()->json(['status'=>'success','result'=>$traduccio_servei], 200);
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
            $traduccio_servei=Traduccio_servei::findOrFail($id);
            return response()->json(['status'=>'success','result'=>$traduccio_servei], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error','result'=>'No existeix aquesta traduccio_servei'], 404);
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