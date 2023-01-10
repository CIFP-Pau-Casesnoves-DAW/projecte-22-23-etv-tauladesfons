<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Comentari::all();
        return response()->json($tuples);
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
        $comentaris = new Comentari();
        $comentaris->ID_COMENTARI = $request->ID_COMENTARI;
        $comentaris->DESCRIPCIO = $request->DESCRIPCIO;
        $comentaris->DATA = $request->DATA;
        $comentaris->HORA = $request->HORA;
        $comentaris->FK_ID_USUARI = $request->FK_ID_USUARI;
        $comentaris->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
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
            $comentaris = Comentari::findOrFail($id);
            return response()->json($comentaris);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comentari not found'], 404);
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
