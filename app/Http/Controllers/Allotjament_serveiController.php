<?php

namespace App\Http\Controllers;

use App\Models\Allotjament_servei;
use Illuminate\Http\Request;

class Allotjament_serveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Allotjament_servei::all();
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
        $allot_serveis = new Allotjament_servei();
        $allot_serveis->FK_ID_ALLOT = $request->FK_ID_ALLOT;
        $allot_serveis->FK_ID_SERVEI = $request->FK_ID_SERVEI;
        $allot_serveis->save();
        return response()->json($allot_serveis);
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
            $allot_serveis = Allotjament_servei::findOrFail($id);
            return response()->json($allot_serveis);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Allotjament_servei not found'], 404);
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
