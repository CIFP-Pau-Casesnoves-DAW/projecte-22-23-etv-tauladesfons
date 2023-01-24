<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_servei;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Traduccio_serveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // ! GET all
    public function getTraduccionsServeis()
    {
        $tuples = Traduccio_servei::all();
        return response()->json(['status' => 'success', 'result' => $tuples], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ! GET de una en especific
    public function getTraduccioServei($id_servei, $id_idioma)
    {
        try {
            $traduccio_servei = Traduccio_servei::where('FK_ID_SERVEI', $id_servei)->where('FK_ID_IDIOMA', $id_idioma)->first();
            return response()->json(['status' => 'success', 'result' => $traduccio_servei], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No existeix aquesta traduccio_servei'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ! INSERT
    public function insertTraduccioServei(Request $request){
        $validacio=Validator::make($request->all(),[
            'FK_ID_SERVEI' => 'exists:serveis,ID_SERVEI',
            'FK_ID_IDIOMA' => 'exists:idiomes,ID_IDIOMA'
        ]);
        if (!$validacio->fails()) {
            $traduccio_servei = new Traduccio_servei();
            $traduccio_servei->FK_ID_SERVEI = $request->FK_ID_SERVEI;
            $traduccio_servei->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
            $traduccio_servei->TRADUCCIO_SERVEI = $request->TRADUCCIO_SERVEI;
            if ($traduccio_servei->save()) {
                return response()->json(['status'=> 'Creat','result'=> $traduccio_servei],200);
            }else {
                return response()->json(['status'=> 'Error creant']);
            }
        }else {
            return response()->json(['status'=> 'Error:servei o idioma inexistents']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // ! UPDATE
    public function updateTraduccioServei(Request $request, $id_servei,$id_idioma){
        //
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // ! DELETE
    public function deleteTraduccioServei($id_servei, $id_idioma)
    {
        $traduccio_servei = Traduccio_servei::where('FK_ID_SERVEI', $id_servei)->where('FK_ID_IDIOMA', $id_idioma)->delete();

        if ($traduccio_servei) {
            return response()->json(['status' => ' Esborrat correctament'], 200);
        } else {
            return response()->json(['status' => 'No trobat'], 404);
        }
    }

    // public function createValidator():array{
    //     return [
    //         "FK_ID_SERVEI" => 
    //     ]
    // }
}
