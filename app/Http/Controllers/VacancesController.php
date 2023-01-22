<?php

namespace App\Http\Controllers;

use App\Models\Vacances;
use Illuminate\Http\Request;

class VacancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuple=Vacances::all();
        return response()->json(['status'=>'success', 'result' => $tuple],200);
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
            'ID_VACANCES' => 'required|integer',
            'NOM_VACANCES' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_VACANCES.required' => 'El camp ID_VACANCES és obligatori.',
            'ID_VACANCES.integer' => 'El camp ID_VACANCES ha de ser un número enter.',
            'NOM_VACANCES.required' => 'El camp NOM_VACANCES és obligatori.',
            'NOM_VACANCES.string' => 'El camp NOM_VACANCES ha de ser una cadena de caràcters.',
            'NOM_VACANCES.max' => 'El camp NOM_VACANCES no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
        $vacances= new Vacances;
        $vacances->ID_VACANCES=$request->input('ID_VACANCES');
        $vacances->NOM_VACANCES=$request->input('NOM_VACANCES');
        $vacances->save();
        return response()->json($vacances, 201);
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
            $vacances=Vacances::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $vacances],200);
        } catch (ModelNotFoundExceptionn $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'han trobat les vacances.'],404);
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
            'ID_VACANCES' => 'required|integer',
            'NOM_VACANCES' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_VACANCES.required' => 'El camp ID_VACANCES és obligatori.',
            'ID_VACANCES.integer' => 'El camp ID_VACANCES ha de ser un número enter.',
            'NOM_VACANCES.required' => 'El camp NOM_VACANCES és obligatori.',
            'NOM_VACANCES.string' => 'El camp NOM_VACANCES ha de ser una cadena de caràcters.',
            'NOM_VACANCES.max' => 'El camp NOM_VACANCES no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Vacances::where('ID_VACANCES', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Vacances modificades correctament.'
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
            $tuples = Vacances::where('ID_VACANCES', $id)->delete();
            return  response()->json([
                'success' => 'Vacances eliminades correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'han pogut eliminar les vacances.'
            ]);
             }
    }
}
