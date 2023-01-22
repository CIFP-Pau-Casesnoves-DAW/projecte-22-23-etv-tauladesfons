<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Exception;
use Illuminate\Http\Request;

class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples=Usuari::all();
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
            'ID_USUARI' => 'required|integer',
            'DNI' => 'required|string|max:9',
            'NOM_COMPLET' => 'required|string|max:50',
            'CORREU_ELECTRONIC' => 'required|string|max:50',
            'CONTRASENYA' => 'required|string|max:50',
            'TELEFON' => 'required|string|max:9',
            'ADMINISTRADOR' => 'required|boolean'
        ];
        $missatges = [
            'ID_USUARI.required' => 'El camp ID_USUARI és obligatori.',
            'ID_USUARI.integer' => 'El camp ID_USUARI ha de ser un número enter.',
            'DNI.required' => 'El camp DNI és obligatori.',
            'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
            'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
            'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
            'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
            'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONICA ha de ser una cadena de caràcters.',
            'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'ADMINISTRADOR.required' => 'El camp ADMINISTRADOR és obligatori.',
            'ADMINISTRADOR.boolean' => 'El camp ADMINISTRADOR ha de ser un booleà.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
        $usuaris= new Usuari;
        $usuaris->ID_USUARI=$request->input('ID_USUARI');
        $usuaris->DNI=$request->input('DNI');
        $usuaris->NOM_COMPLET=$request->input('NOM_COMPLET');
        $usuaris->CORREU_ELECTRONIC=$request->input('CORREU_ELECTRONIC');
        $usuaris->CONTRASENYA=$request->input('CONTRASENYA');
        $usuaris->TELEFON=$request->input('TELEFON');
        $usuaris->ADMINISTRADOR=$request->input('ADMINISTRADOR');
        $usuaris->save();
        return response()->json(['status'=>'success','result'=>$usuaris], 201);
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
            $usuaris=Usuari::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $usuaris],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat l\'usuari'],404);
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
            'ID_USUARI' => 'required|integer',
            'DNI' => 'required|string|max:9',
            'NOM_COMPLET' => 'required|string|max:50',
            'CORREU_ELECTRONIC' => 'required|string|max:50',
            'CONTRASENYA' => 'required|string|max:50',
            'TELEFON' => 'required|string|max:9',
            'ADMINISTRADOR' => 'required|boolean'
        ];
        $missatges = [
            'ID_USUARI.required' => 'El camp ID_USUARI és obligatori.',
            'ID_USUARI.integer' => 'El camp ID_USUARI ha de ser un número enter.',
            'DNI.required' => 'El camp DNI és obligatori.',
            'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
            'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
            'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
            'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
            'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONICA ha de ser una cadena de caràcters.',
            'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'ADMINISTRADOR.required' => 'El camp ADMINISTRADOR és obligatori.',
            'ADMINISTRADOR.boolean' => 'El camp ADMINISTRADOR ha de ser un booleà.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Uusari::where('ID_USUARI', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Usuari modificat correctament'
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
            $tuples =Usuari::where('ID_USUARI', $id)->delete();
            return  response()->json([
                'success' => 'Usuari eliminat correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar l\'usuari.'
            ]);
             }
    }
}
