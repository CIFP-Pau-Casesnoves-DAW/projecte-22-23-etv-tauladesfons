<?php

namespace App\Http\Controllers;

use App\Models\Fotografia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class FotografiaController extends Controller
{


    public function getFotografies()
    {
        $foto = Fotografia::all();
        return response()->json($foto);
    }


    public function insertFotografia(Request $request)
    {
        $validacio = Validator::make($request->all(), [
            'ID_FOTO' => 'required|integer',
            'FOTO' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ]);

        if ($validacio->fails()) {
            return response()->json(['error' => $validacio->errors()->first()], 400);
        } else {
            $foto = new Fotografia();
            $foto->ID_FOTO = $request->ID_FOTO;
            $foto->FOTO = $request->FOTO;
            $foto->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
            $foto->save();
            return response()->json($foto, 201);
        }
    }

    public function getFotografia($id)
    {
        try {
            $foto = Fotografia::findOrFail($id);
            return response()->json([
                'success' => 'Fotografia trobada correctament',
                'result' => $foto
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
        }
    }



    public function updateFotografia(Request $request, $id)
    {
        $regles = [
            'ID_FOTO' => 'required|integer',
            'FOTO' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];

        $missatge = [
            'required' => 'El camp :attribute és obligatori',
            'integer' => 'El camp :attribute ha de ser un número enter'
        ];
        $foto = Validator::make($request->all(), $regles, $missatge);
        if ($foto->fails()) {
            return response()->json(['error' => $foto->errors()->first()], 400);
        } else {
            try {
                $foto = Fotografia::findOrFail($id);
                $foto->ID_FOTO = $request->ID_FOTO;
                $foto->FOTO = $request->FOTO;
                $foto->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
                $foto->save();
                return response()->json([
                    'success' => 'Fotografia actualitzada correctament',
                    'result' => $foto
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
            }
        }
    }

    public function deleteFotografia($id)
    {
        $foto = Fotografia::find($id);
        if ($foto) {
            $foto->delete();
            return response()->json(['success' => 'Fotografia eliminada correctament'], 200);
        } else {
            return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
        }
    }
}
