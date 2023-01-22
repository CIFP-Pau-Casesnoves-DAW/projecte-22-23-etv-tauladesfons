<?php

namespace App\Http\Controllers;

use App\Models\Municipi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MunicipiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tuples = Municipi::all();
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
        $reglesvalidacio = [
            'ID_MUNICIPI' => 'required|integer',
            'NOM_MUNICIPI' => 'required|string|max:50',
        ];
        $missatges = [
            'ID_MUNICIPI.required' => 'El camp ID_MUNICIPI és obligatori',
            'ID_MUNICIPI.integer' => 'El camp ID_MUNICIPI ha de ser un número enter',
            'NOM_MUNICIPI.required' => 'El camp NOM_MUNICIPI és obligatori',
            'NOM_MUNICIPI.string' => 'El camp NOM_MUNICIPI ha de ser una cadena de caràcters',
            'NOM_MUNICIPI.max' => 'El camp NOM_MUNICIPI no pot tenir més de 50 caràcters',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            $tuples = Municipi::create($request->all());
            return response()->json([
                'status' => 'success',
                'data' => $tuples
            ], 200);
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
            $municipis = Municipi::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $municipis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Municipi not found'
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
        $reglesvalidacio = [
            'ID_MUNICIPI' => 'required|integer',
            'NOM_MUNICIPI' => 'required|string|max:50',
        ];
        $missatges = [
            'ID_MUNICIPI.required' => 'El camp ID_MUNICIPI és obligatori',
            'ID_MUNICIPI.integer' => 'El camp ID_MUNICIPI ha de ser un número enter',
            'NOM_MUNICIPI.required' => 'El camp NOM_MUNICIPI és obligatori',
            'NOM_MUNICIPI.string' => 'El camp NOM_MUNICIPI ha de ser una cadena de caràcters',
            'NOM_MUNICIPI.max' => 'El camp NOM_MUNICIPI no pot tenir més de 50 caràcters',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $municipis = Municipi::findOrFail($id);
                $municipis->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $municipis
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Municipi not found'
                ], 404);
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
        $tuples = Municipi::finorFail($id);
        $tuples->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Municipi deleted'
        ], 200);
    }
}
