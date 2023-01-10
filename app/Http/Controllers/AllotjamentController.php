<?php

namespace App\Http\Controllers;

use App\Models\Allotjament;
use Illuminate\Http\Request;

class AllotjamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Allotjament::all();
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
        $allotjaments = new Allotjament();
        $allotjaments->ID_ALLOTJAMENT = $request->ID_ALLOTJAMENT;
        $allotjaments->NOM_COMERCIAL = $request->NOM_COMERCIAL;
        $allotjaments->NUM_REGISTRE = $request->NUM_REGISTRE;
        $allotjaments->DESCRIPCIO = $request->DESCRIPCIO;
        $allotjaments->LLITS = $request->LLITS;
        $allotjaments->PERSONES = $request->PERSONES;
        $allotjaments->BANYS = $request->BANYS;
        $allotjaments->FOTOGRAFIES = $request->FOTOGRAFIES;
        $allotjaments->ADRECA = $request->ADRECA;
        $allotjaments->DESTACAT = $request->DESTACAT;
        $allotjaments->VALORACIO_GLOBAL = $request->VALORACIO_GLOBAL;
        $allotjaments->FK_ID_MUNICIPI = $request->FK_ID_MUNICIPI;
        $allotjaments->FK_ID_TIPUS = $request->FK_ID_TIPUS;
        $allotjaments->FK_ID_SERVEI = $request->FK_ID_SERVEI;
        $allotjaments->FK_ID_VACANCES = $request->FK_ID_VACANCES;
        $allotjaments->FK_ID_CATEGORIA = $request->FK_ID_CATEGORIA;
        $allotjaments->FK_ID_USUARI = $request->FK_ID_USUARI;
        $allotjaments->save();
        return response()->json($allotjaments);

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
            $allotjaments = Allotjament::findOrFail($id);
            return response()->json($allotjaments);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No s\'ha trobat l\'allotjament'], 404);
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
