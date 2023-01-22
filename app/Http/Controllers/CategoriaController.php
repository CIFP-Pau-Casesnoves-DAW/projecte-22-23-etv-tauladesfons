<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Categoria::all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_CATEGORIA' => 'required',
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'ID_CATEGORIA.required' => 'El camp ID_CATEGORIA és obligatori',
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $categoria = new Categoria();
            $categoria->ID_CATEGORIA = $request->input('ID_CATEGORIA');
            $categoria->NOM_CATEGORIA = $request->input('NOM_CATEGORIA');
            $categoria->TARIFA = $request->input('TARIFA');
            $categoria->save();
            return response()->json(['status' => 'Categoria creada correctament'], 201);
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
            $categories = Categoria::findOrFail($id);
            return response()->json($categories);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoria not found'], 404);
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
            'ID_CATEGORIA' => 'required',
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'ID_CATEGORIA.required' => 'El camp ID_CATEGORIA és obligatori',
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $categoria = Categoria::findOrFail($id);
            $categoria->ID_CATEGORIA = $request->input('ID_CATEGORIA');
            $categoria->NOM_CATEGORIA = $request->input('NOM_CATEGORIA');
            $categoria->TARIFA = $request->input('TARIFA');
            $categoria->save();
            return response()->json(['status' => 'Categoria actualitzada correctament'], 200);
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
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return response()->json(['status' => 'Categoria eliminada correctament'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoria not found'], 404);
        }
    }
}
