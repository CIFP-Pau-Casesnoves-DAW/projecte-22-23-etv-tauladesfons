<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Reserva::all();
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
        $reserves= new Reserva;
        $reserves->ID_RESERVA=$request->ID_RESERVA;
        $reserves->FK_ID_CLIENT=$request->FK_ID_CLIENT;
        $reserves->FK_ID_ALLOTJAMENT=$request->FK_ID_ALLOTJAMENT;
        $reserves->DATA_INICIAL=$request->DATA_INICIAL;
        $reserves->DATA_FINAL=$request->DATA_FINAL;
        $reserves->CONFIRMADA=$request->CONFIRMADA;
        $reserves->save();
        return response()->json(['status'=>'success','result'=>$reserves], 200);
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
            $tuples=Reserva::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $tuples],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No existeix aquesta reserva'],404);
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
