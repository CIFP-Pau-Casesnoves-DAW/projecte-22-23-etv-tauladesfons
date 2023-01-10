<?php

namespace App\Http\Controllers;

use App\Models\Valoracio;
use Illuminate\Http\Request;

class ValoracioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Valoracio::all();
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
        $valoracions= new Valoracio;
        $valoracions->ID_VALORACIO=$request->ID_VALORACIO;
        $valoracions->PUNTUACIO=$request->PUNTUACIO;
        $valoracions->FK_ID_USUARI=$request->FK_ID_USUARI;
        $valoracions->FK_ID_ALLOTJAMENT=$request->FK_ID_ALLOTJAMENT;
        $valoracions->save();
        return response()->json(['status'=>'success','result'=>$valoracions], 200);
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
            $valoracions=Valoracio::findOrFail($id);
            return response()->json(['status'=>'success','result'=>$valoracions], 200);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','result'=>'Valoracio not found'], 404);
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
