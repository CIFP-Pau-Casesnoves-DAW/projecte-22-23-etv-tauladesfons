<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use http\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class IdiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Idioma::all();

        // Return the list of languages to the client
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
       $reglesvalidacio=[
           'ID_IDIOMA' => 'required|integer',
              'NOM_IDIOMA' => 'required|string',
        ];
        $missatges=[
            'ID_IDIOMA.required' => 'El camp ID_IDIOMA és obligatori',
            'ID_IDIOMA.integer' => 'El camp ID_IDIOMA ha de ser un número enter',
            'NOM_IDIOMA.required' => 'El camp NOM_IDIOMA és obligatori',
            'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser una cadena de caràcters',
        ];
        $validador = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validador->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validador->errors()->all()
            ], 400);
        }
        $tuple = new Idioma;
        $tuple->ID_IDIOMA = $request->input('ID_IDIOMA');
        $tuple->NOM_IDIOMA = $request->input('NOM_IDIOMA');
        $tuple->save();
        return response()->json([
            'status' => 'success',
            'data' => $tuple
        ], 201);
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
            $tuples=Idioma::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $tuples],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'],404);
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
        try {
            $tuples = Idioma::findOrFail($id);
            $reglesValidacio = [
                'ID_IDIOMA' => ['filled', 'unique:ID_IDIOMA,' . $id],
                'NOM_IDIOMA' => ['filled', 'string', 'max:50']
            ];
            $missatge = [
                'ID_IDIOMA.filled' => 'El camp ID_IDIOMA és obligatori',
                'ID_IDIOMA.unique' => 'Aquest ID_IDIOMA ja existeix',
                'NOM_IDIOMA.filled' => 'El camp NOM_IDIOMA és obligatori',
                'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser de tipus string',
                'NOM_IDIOMA.max' => 'El camp NOM_IDIOMA no pot tenir més de 50 caràcters'
            ];
            $validacio = Validator::make($request->all(), $reglesValidacio, $missatge);
            if ($validacio->fails()) {
                return response()->json(['status' => 'error', 'result' => $validacio->errors()], 400);
            } else {
                $tuples->ID_IDIOMA = $request->ID_IDIOMA;
                $tuples->NOM_IDIOMA = strtoupper($request->NOM_IDIOMA);
                $tuples->save();
                return response()->json(['status' => 'success', 'result' => $tuples], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'], 404);
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
            $tuples=Idioma::findOrFail($id);
            $tuples->delete();
            return response()->json(['status'=>'success', 'result' => 'S\'ha eliminat l\'idioma correctament'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'],404);
        }
    }
}
