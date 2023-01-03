<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_tipus;
use Illuminate\Http\Request;

class Traduccio_tipusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Traduccio_tipus::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
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
        $traduccio_tipus = new Traduccio_tipus();
        $traduccio_tipus->FK_ID_TIPUS = $request->FK_ID_TIPUS;
        $traduccio_tipus->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
        $traduccio_tipus->TRADUCCIO_TIPUS = strtoupper($request->TRADUCCIO_TIPUS);
        $traduccio_tipus->save();
        return response()->json(['status' => 'success', 'result' => $traduccio_tipus], 200);
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
            $traduccio_tipus = Traduccio_tipus::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $traduccio_tipus
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap traducció de tipus amb aquest ID'
            ], 404);
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
