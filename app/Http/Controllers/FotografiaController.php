<?php

namespace App\Http\Controllers;

use App\Models\Allotjament;
use App\Models\Fotografia;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class FotografiaController extends Controller
{

/**
     * @OA\Get(
     * path="/fotografies",
     * tags={"Fotografies"},
     * summary="Mostrar totes les imatges.",
     * @OA\Response(
     * response=200,
     * description="Mostrar totes les imatges.",
     *          @OA\JsonContent(
     *          @OA\Property(property="Status", type="string", example="200"),
     *          @OA\Property(property="Result",type="object")
     *  ),
     *  ),
     *   @OA\Response(
     *         response=400,
     *         description="Hi ha un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="Status", type="string", example="Error"),
     *          @OA\Property(property="Result",type="string", example="Informacio de l'error")
     *         ),
     *   )
     * )
     */
    public function getAllFotografies()
    {
        $foto = Fotografia::all();
        return response()->json($foto);
    }

    /**
     * @OA\Post(
     *    path="/fotografies",
     *    tags={"Fotografies"},
     *    summary="Crea una imatge",
     *    description="Crea una nova imatge.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="FOTO", type="string", format="binary"),
     *              @OA\Property(property="DESCRIPCIO", type="varchar", example="casa rural amb vistea a muntanya"),
     *              @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", example="2"),
     *           )
     *        )
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *      @OA\Response(
     *         response=400,
     *         description="Hi ha un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="Error"),
     *          @OA\Property(property="message",type="string", example="Informacio de l'error")
     *           ),
     *     )
     *  )
     */
    public function insertFotografia(Request $request)
    {
        try {
            $allotjament = Allotjament::findOrFail($request->FK_ID_ALLOTJAMENT);
            if ($request->esAdministrador || $request->validat_id == $allotjament->FK_ID_USUARI) {
                $missatges = [
                    'required' => 'Foto no rebuda',
                    'mimes' => 'La foto ha de ser de format jpeg,jpg,bmp,png',
                    'max' => 'Excedit tamany màxim'
                ];
                $reglesValidacio = [
                    'FOTO' => 'required|mimes:jpg,jpeg,mbp,png|max:10240',
                    'DESCRIPCIO' => 'max:200'
                ];
                $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
                if (!$validacio->fails()) {
                    if ($request->hasFile('FOTO')) {
                        $original_filename = $request->file('FOTO')->getClientOriginalName();
                        $original_filename_arr = explode('.', $original_filename);
                        $file_text = end($original_filename_arr);
                        $destination_path = base_path('public/imatges');
                        $image = 'etv_' . time() . '.' . $file_text;
                        if ($request->file("FOTO")->move($destination_path, $image)) {
                            $fotografia = new Fotografia();
                            $fotografia->URL = URL::to('/imatges') . '/'. $image;
                            $fotografia->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
                            if ($request->has('DESCRIPCIO')) {
                                $fotografia->DESCRIPCIO = $request->DESCRIPCIO;
                            }
                            $fotografia->save();
                            return response()->json(['status' => 'success', 'data' => $fotografia],200);
                        }else {
                            return response()->json(['status' => 'error' , 'message' => 'Error guardant'],400);
                        }
                    }else{
                        return response()->json(['status' => 'error' , 'message' => 'Fitxer no trobat'],400);
                    }
                }else{
                    return response()->json(['status' => 'error' , 'message' => $validacio->errors()],400);
                }
            }else {
                return response()->json(['status' => 'error' , 'message' => 'No ets propietari de l\'allotjament seleccionat'],404);
            }
            
        } catch (Exception $e) {
            return response()->json(['status' => 'error' , 'message' => 'L\'allotjament seleccionat no existeix'],404);
        }
        

    }
    /**
     * @OA\Get(
     *     path="/fotografies/{id}",
     *     tags={"Fotografies"},
     *     summary="Mostrar una imatge",
     *     @OA\Parameter(
     *         description="Id de la imatge",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number"),
     *
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informació de la imatge.",
     *          @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="200"),
     *          @OA\Property(property="data",type="object")
     *           ),
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Hi ha un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="message",type="string", example="Informacio de l'error")
     *           ),
     *     )
     * )
     */
    public function getFotografia($id)
    {
        try {
            $foto = Fotografia::findOrFail($id);
            return response()->json([
                'success' => 'success',
                'data' => $foto
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error','message' => 'No s\'ha trobat la fotografia'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/fotografies/allotjament/{idAllotjament}",
     *     tags={"Fotografies"},
     *     summary="Mostrar totes les imatges de un allotjament",
     *     @OA\Parameter(
     *         description="id allotjament",
     *         in="path",
     *         name="idAllotjament",
     *         required=true,
     *         @OA\Schema(type="number"),
     *
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data",type="object")
     *          )
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Hi ha un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="message",type="string", example="Informacio de l'error")
     *           ),
     *     )
     * )
     */
    public function getFotografiesAllotjament($idAllotjament)
    {
            $imatges = Fotografia::where("FK_ID_ALLOTJAMENT","=",$idAllotjament)->get();
            return response()->json(["status" => "success","data" => $imatges], 200);
    }


        /**
     *  @OA\Put(
     *     path="/fotografies/put/{id}",
     *     summary="Actualitza una fotografia",
     *     tags={"Fotografies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID de la fotografia",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     @OA\Property(property="DESCRIPCIO", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Fotografia actualitzada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="data", type="object", example="object")
     * )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string", example= "error"),
     *     @OA\Property(property="message",type="string", example="Informacio de l'error")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Fotografia no trobada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="message", type="string", example="Informacio de l'error")
     * )
     * )
     * )
     *
     */
    public function updateFotografia(Request $request, $id)
    {
        try {
            $imatge=Fotografia::findOrFail($id);
            $allotjament = Allotjament::findOrFail($imatge->FK_ID_ALLOTJAMENT);
                if ($request->esAdministrador || $request->validat_id == $allotjament->FK_ID_USUARI) {
                    $imatge->DESCRIPCIO=$request->DESCRIPCIO;
                    $imatge->save();
                    return response()->json(['status' => 'success' , 'data' => $imatge],200);
                }else{
                    return response()->json(['status' => 'error' , 'message' => 'No ets propietari de l\'imatge seleccionada'],404);
                }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error','message' => 'No s\'ha trobat la fotografia'], 404);
        }
    }
    /**
     * @OA\Delete(
     *     path="/fotografies/destroy/{id}",
     *     summary="Elimina una fotografia",
     *     tags={"Fotografies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID de la fotografia",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Fotogradia eliminada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Fotografia no trobada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */
    public function deleteFotografia($id, Request $request)
    {
        try {
            $imatge=Fotografia::findOrFail($id);
            $allotjament = Allotjament::findOrFail($imatge->FK_ID_ALLOTJAMENT);
                if ($request->esAdministrador || $request->validat_id == $allotjament->FK_ID_USUARI) {
                    $imatge->delete();
                    return response()->json(['status' => 'success' , 'data' => 'Imatge eliminada correctament'],200);
                }else{
                    return response()->json(['status' => 'error' , 'message' => 'No ets propietari de l\'imatge seleccionada'],404);
                }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error','message' => 'No s\'ha trobat la fotografia'], 404);
        }
    }
}
