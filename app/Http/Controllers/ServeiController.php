<?php

namespace App\Http\Controllers;

use App\Models\Servei;
use Exception;
use Illuminate\Http\Request;

class ServeiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Servei::all();
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
        $reglesvalidacio = [
            'ID_SERVEI' => 'required|integer',
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_SERVEI.required' => 'El camp ID_SERVEI és obligatori.',
            'ID_SERVEI.integer' => 'El camp ID_SERVEI ha de ser un número enter.',
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
        $serveis= new Servei;
        $serveis->ID_SERVEI=$request->input('ID_SERVEI');
        $serveis->NOM_SERVEI=$request->input('NOM_SERVEI');
        $serveis->save();
        return response()->json(['status'=>'success','result'=>$serveis], 200);
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
            $serveis=Servei::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $serveis],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat aquest servei'],404);
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
        $reglesvalidacio = [
            'ID_SERVEI' => 'required|integer',
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_SERVEI.required' => 'El camp ID_SERVEI és obligatori.',
            'ID_SERVEI.integer' => 'El camp ID_SERVEI ha de ser un número enter.',
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Servei::where('ID_SERVEI', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Servei modificat correctament.'
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
            $tuples = Servei::where('ID_SERVEI', $id)->delete();
            return  response()->json([
                'success' => 'Servei eliminat correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar el servei.'
            ]);
             }
    }
}
