<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_tipus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 *@OA\Tag(name="Traduccio_tipus")
 */

class Traduccio_tipusController extends Controller
{

    // ! GET all
    public function getTraduccionsTipus()
    {
        $tuples = Traduccio_tipus::all();
        return response()->json(['status' => 'success', 'result' => $tuples], 200);
    }


    // ! GET de una en especific
    public function getTraduccioTipus($id_vacances, $id_idioma)
    {
        try {
            $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_vacances)->where('FK_ID_IDIOMA', $id_idioma)->first();
            return response()->json(['status' => 'success', 'result' => $traduccio_tipus], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No existeix aquesta traduccio_tipus'], 404);
        }
    }


    // ! INSERT
    public function insertTraduccioTipus(Request $request)
    {
        $validacio = Validator::make($request->all(), [
            'FK_ID_TIPYS' => 'exists:tipus,ID_tipus',
            'FK_ID_IDIOMA' => 'exists:idiomes,ID_IDIOMA'
        ]);
        if (!$validacio->fails()) {
            $traduccio_tipus = new Traduccio_tipus();
            $traduccio_tipus->FK_ID_TIPUS = $request->FK_ID_TIPUS;
            $traduccio_tipus->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
            $traduccio_tipus->TRADUCCIO_TIPUS = $request->TRADUCCIO_TIPUS;
            if ($traduccio_tipus->save()) {
                return response()->json(['status' => 'Creat', 'result' => $traduccio_tipus], 200);
            } else {
                return response()->json(['status' => 'Error creant']);
            }
        } else {
            return response()->json(['status' => 'Error:tipus o idioma inexistents']);
        }
    }

    // ! UPDATE
    public function updateTraduccioTipus(Request $request, $id_tipus, $id_idioma)
    {
        $reglesValidacio = [
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_IDIOMA' => 'required|integer',
            'TRADUCCIO_TIPUS' => 'required|string|max:50'
        ];
        $missatges = [
            'FK_ID_TIPUS.required' => 'El camp de FK_ID_TIPUS és obligatori',
            'FK_ID_TIPUS.integer' => 'El camp de FK_ID_TIPUS ha de ser un enter',
            'FK_ID_IDIOMA.required' => 'El camp de FK_ID_IDIOMA és obligatori',
            'FK_ID_IDIOMA.integer' => 'El camp de FK_ID_IDIOMA ha de ser un enter',
            'TRADUCCIO_TIPUS.required' => 'El camp de TRADUCCIO_TIPUS és obligatori',
            'TRADUCCIO_TIPUS.max' => 'El camp TRADUCCIO_TIPUS no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_tipus)->where('FK_ID_IDIOMA', $id_idioma);
                $traduccio_tipus->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_tipus
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del servei amb la id ' . $id_tipus . 'amb idioma' . $id_idioma . 'no existeix'
                ], 404);
            }
        }
    }

    public function deleteTraduccioTipus($id_tipus, $id_idioma)
    {
        $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_tipus)->where('FK_ID_IDIOMA', $id_idioma)->delete();

        if ($traduccio_tipus) {
            return response()->json(['status' => ' Esborrat correctament'], 200);
        } else {
            return response()->json(['status' => 'No trobat'], 404);
        }
    }
}
