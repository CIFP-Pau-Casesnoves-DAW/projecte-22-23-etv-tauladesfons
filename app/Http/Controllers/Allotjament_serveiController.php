<?php

namespace App\Http\Controllers;

use App\Models\Allotjament_servei;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $reglevalidacio=Validator::make($request->all(), [
            'FK_ID_ALLOT' => 'exists:ALLOTJAMENTS,ID_ALLOTJAMENT',
            'FK_ID_SERVEI' => 'exists:SERVEIS,ID_SERVEI'
        ]);
        if (!$reglevalidacio->fails()) {
            $tuple = new Allotjament_servei();
            $tuple->FK_ID_ALLOT = $request->FK_ID_ALLOT;
            $tuple->FK_ID_SERVEI = $request->FK_ID_SERVEI;
            if ($tuple->save()) {
                return response()->json(['status' => 'Afegit','result' => $tuple], 200);
            } else {
                return response()->json(['status' => 'Error'], 500);
            }
        } else {
            return response()->json(['status' => 'Error creant'], 500);
        }
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
        $reglesvalidacio = Validator::make($request->all(), [
            'FK_ID_ALLOT' => 'exists:ALLOTJAMENTS,ID_ALLOTJAMENT',
            'FK_ID_SERVEI' => 'exists:SERVEIS,ID_SERVEI'
        ]);
        if (!$reglesvalidacio->fails()) {
            $tuple = Allotjament_servei::findOrFail($id);
            $tuple->FK_ID_ALLOT = $request->FK_ID_ALLOT;
            $tuple->FK_ID_SERVEI = $request->FK_ID_SERVEI;
            if ($tuple->save()) {
                return response()->json(['status' => 'Actualitzat','result' => $tuple], 200);
            } else {
                return response()->json(['status' => 'Error'], 500);
            }
        } else {
            return response()->json(['status' => 'Error actualitzant'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $FK_ID_ALLOT
     * @param $FK_ID_SERVEI
     * @return Response
     */
    public function destroy($FK_ID_ALLOT, $FK_ID_SERVEI)
    {
        $tuple = Allotjament_servei::where('FK_ID_ALLOT', $FK_ID_ALLOT)->where('FK_ID_SERVEI', $FK_ID_SERVEI)->delete();
        if ($tuple) {
            return response()->json(['success' => 'Allotjament_servei eliminat'], 200);
        } else {
            return response()->json(['error' => 'Allotjament_servei no eliminat'], 404);
        }
    }
}
