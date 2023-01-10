<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_vacances;
use Illuminate\Http\Request;

class Traduccio_vacancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuple = Traduccio_vacances::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuple
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
        $traduccio_vacances = new Traduccio_vacances();
$traduccio_vacances->FK_ID_VACANCES = $request->FK_ID_VACANCES;
$traduccio_vacances->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
$traduccio_vacances->TRADUCCCIO_VAC= $request->TRADUCCCIO_VAC;
$traduccio_vacances->save();
        return response()->json(['status' => 'success', 'result' => $traduccio_vacances], 200);
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
            $traduccio_vacances = Traduccio_vacances::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $traduccio_vacances
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat la traduccio_vacances amb id ' . $id
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
