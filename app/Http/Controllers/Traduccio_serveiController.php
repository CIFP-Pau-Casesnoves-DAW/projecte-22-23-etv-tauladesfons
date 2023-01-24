<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_servei;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Traduccio_serveis")
 */

class Traduccio_serveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/traduccio_serveis",
     *     tags={"Traduccio_serveis"},
     *     summary="Obtenir totes les traduccions de serveis",
     *     description="Obtenir totes les traduccions de serveis",
     *     operationId="getTraduccionsServei",
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Traduccio_servei",
     *     type="object",
     *     @OA\Property(property="FK_ID_SERVEI", type="integer"),
     *     @OA\Property(property="FK_ID_IDIOMA", type="integer"),
     *     @OA\Property(property="TRADUCCIO_SERVEI", type="string")
     * )
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
    /**
     * @OA\Get(
     *     path="/traduccio_serveis/{id_servei}/{id_idioma}",
     *     tags={"Traduccio_serveis"},
     *     summary="Obtenir una traduccio de servei",
     *     description="Obtenir una traduccio de servei",
     *     operationId="getTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *    )
     *  ), @OA\Response(
     *     response=404,
     *     description="Traduccio_servei no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *   )
     * )
     * )
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
    /**
     * @OA\Post(
     *     path="/traduccio_serveis",
     *     tags={"Traduccio_serveis"},
     *     summary="Crear una traduccio de servei",
     *     description="Crear una traduccio de servei",
     *     operationId="insertTraduccioServei",
     *     @OA\RequestBody(
     *         description="Traduccio_servei a crear",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *         )
     *     )
     * )
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
    /**
     * @OA\Put(
     *     path="/traduccio_serveis/put/{id_servei}/{id_idioma}",
     *     tags={"Traduccio_serveis"},
     *     summary="Actualitzar una traduccio de servei",
     *     description="Actualitzar una traduccio de servei",
     *     operationId="updateTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Traduccio_servei a actualitzar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *         )
     *     )
     * )
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
    /**
     * @OA\Delete(
     *     path="/traduccio_serveis/destroy/{id_servei}/{id_idioma}",
     *     tags={"Traduccio_serveis"},
     *     summary="Esborrar una traduccio de servei",
     *     description="Esborrar una traduccio de servei",
     *     operationId="deleteTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     )
     * )
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
