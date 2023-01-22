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
        $reglesvalidacio  = [
            'ID_VALORACIO' => 'required|integer',
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'ID_VALORACIO.required' => 'El camp ID_VALORACIO és obligatori.',
            'ID_VALORACIO.integer' => 'El camp ID_VALORACIO ha de ser un número enter.',
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $valoracions= new Valoracio();
            $valoracions->ID_VALORACIO=$request->input('ID_VALORACIO');
            $valoracions->PUNTUACIO=$request->input('PUNTUACIO');
            $valoracions->FK_ID_USUARI=$request->input('FK_ID_USUARI');
            $valoracions->FK_ID_ALLOTJAMENT=$request->input('FK_ID_ALLOTJAMENT');
            $valoracions->save();
            return response()->json(['status'=>'success','result'=>$valoracions], 200);
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
            $valoracions=Valoracio::findOrFail($id);
            return response()->json(['status'=>'success','result'=>$valoracions], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error','result'=>'No s\'ha trobat la valoració.'], 404);
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
        $reglesvalidacio  = [
            'ID_VALORACIO' => 'required|integer',
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'ID_VALORACIO.required' => 'El camp ID_VALORACIO és obligatori.',
            'ID_VALORACIO.integer' => 'El camp ID_VALORACIO ha de ser un número enter.',
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Valoracio::where('ID_VALORACIO', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Valoració modificada correctament.'
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tuples = Valoracio::where('ID_VALORACIO', $id)->delete();
            return  response()->json([
                'success' => 'Valoració eliminada correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar la valoració.'
            ]);
        }
    }
}