<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Comentari::all();
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
        $reglesvalidacio = [
            'ID_COMENTARI' => 'required',
            'DESCRIPCIO' => 'required|max:255',
            'HORA' => 'required|date_format:H:i:s',
            'DATA' => 'required|date_format:Y-m-d',
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required'

        ];
        $missatges = [
            'ID_COMENTARI.required' => 'El camp ID_COMENTARI és obligatori',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters',
            'HORA.required' => 'El camp HORA és obligatori',
            'HORA.date_format' => 'El camp HORA no té el format correcte',
            'DATA.required' => 'El camp DATA és obligatori',
            'DATA.date_format' => 'El camp DATA no té el format correcte',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        } else {
            $comentaris = new Comentari();
            $comentaris->ID_COMENTARI = $request->input('ID_COMENTARI');
            $comentaris->DESCRIPCIO = $request->input('DESCRIPCIO');
            $comentaris->HORA = $request->input('HORA');
            $comentaris->DATA = $request->input('DATA');
            $comentaris->FK_ID_USUARI = $request->input('FK_ID_USUARI');
            $comentaris->FK_ID_ALLOTJAMENT = $request->input('FK_ID_ALLOTJAMENT');
            $comentaris->save();
            return response()->json(['status' => 'Comentari creat correctament'], 201);
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
            $comentaris = Comentari::findOrFail($id);
            return response()->json($comentaris);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comentari no trobat'], 404);
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
            'ID_COMENTARI' => 'required',
            'DESCRIPCIO' => 'required|max:255',
            'HORA' => 'required|date_format:H:i:s',
            'DATA' => 'required|date_format:Y-m-d',
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required'

        ];
        $missatges = [
            'ID_COMENTARI.required' => 'El camp ID_COMENTARI és obligatori',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters',
            'HORA.required' => 'El camp HORA és obligatori',
            'HORA.date_format' => 'El camp HORA no té el format correcte',
            'DATA.required' => 'El camp DATA és obligatori',
            'DATA.date_format' => 'El camp DATA no té el format correcte',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        } else {
            try {
                $comentaris = Comentari::findOrFail($id);
                $comentaris->ID_COMENTARI = $request->input('ID_COMENTARI');
                $comentaris->DESCRIPCIO = $request->input('DESCRIPCIO');
                $comentaris->HORA = $request->input('HORA');
                $comentaris->DATA = $request->input('DATA');
                $comentaris->FK_ID_USUARI = $request->input('FK_ID_USUARI');
                $comentaris->FK_ID_ALLOTJAMENT = $request->input('FK_ID_ALLOTJAMENT');
                $comentaris->save();
                return response()->json(['status' => 'Comentari actualitzat correctament'], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Comentari no trobat'], 404);
            }
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
            $comentaris = Comentari::findOrFail($id);
            $comentaris->delete();
            return response()->json(['status' => 'Comentari eliminat correctament'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comentari no trobat'], 404);
        }
    }
}
