<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Usuaris")
 */
class UsuariController extends Controller
{
    // ! GET de tots
    /**
     * @OA\Get(
     *     path="/usuaris",
     *     tags={"Usuaris"},
     *     summary="Llista tots els usuaris",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array",@OA\Items(
     *                 @OA\Property(property="ID_USUARI", type="integer", example=1),
     *                 @OA\Property(property="DNI", type="string", example="12345678Z"),
     *                 @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *                 @OA\Property(property="CORREU_ELECTRONIC", type="string", example=" patata@gmail.com")
     *            ))
     *        )
     *    ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="Unauthorized")
     *    )
     * )
     * )
     * @OA\Schema(
     *     schema="Usuari",
     *     @OA\Property(property="ID_USUARI", type="integer", example=1),
     *     @OA\Property(property="DNI", type="string", example="12345678Z"),
     *     @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *     @OA\Property(property="CORREU_ELECTRONIC", type="string", example="patata@gmail.com"),
     *     @OA\Property(property="CONTRASENYA", type="string", example="12345678Z"),
     *     @OA\Property(property="TELEFON", type="string", example="12345678Z")
     *
     * )
     */
    public function getAllUsuaris(Request $request)
    {
        if ($request->esAdministrador) {
            $tuples = Usuari::all();
            return response()->json([
                'status' => 'success',
                'data' => $tuples
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'permisos insuficients'
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/usuaris",
     *     summary="Crear un usuari",
     *     tags={"Usuaris"},
     *     description="Crear un nou usuari",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *             @OA\Property(property="CONTRASENYA", type="string", example="abcdefg"),             
     *             @OA\Property(property="CORREU_ELECTRONIC", type="string", example="perepujol@gmail.com"),
     *             @OA\Property(property="DNI", type="string", example="12345678Z"),
     *             @OA\Property(property="TELEFON", type="string", example="123456789")
     *        )
     *    ),
     *     @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="integer", example="success"),
     *     @OA\Property(property="data",type="object")
     *   ))
     * )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="No autoritzat",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="Unauthorized")
     *   )
     * )
     * )
     */
    public function insertUsuaris(Request $request)
    {
        $reglesvalidacio = [
            'DNI' => 'required|string|max:9',
            'NOM_COMPLET' => 'required|string|max:50',
            'CORREU_ELECTRONIC' => 'required|string|max:50|unique:USUARIS,CORREU_ELECTRONIC',
            'CONTRASENYA' => 'required|string|max:50',
            'TELEFON' => 'required|string|max:9'
        ];
        $missatges = [
            'DNI.required' => 'El camp DNI és obligatori.',
            'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
            'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
            'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
            'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
            'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONIC ha de ser una cadena de caràcters.',
            'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.unique' => 'El camp CORREU_ELECTRONIC ja s\'està empleant',
            'CONTRASENYA.required' => 'El camp CONTRASENYA és obligatori.',
            'CONTRASENYA.string' => 'El camp CONTRASENYA ha de ser una cadena de caràcters.',
            'CONTRASENYA.max' => 'El camp CONTRASENYA no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $usuari = new Usuari;
            $usuari->NOM_COMPLET = $request->input('NOM_COMPLET');
            $usuari->CONTRASENYA = Hash::make($request->input('CONTRASENYA'));
            $usuari->CORREU_ELECTRONIC = $request->input('CORREU_ELECTRONIC');
            $usuari->DNI = $request->input('DNI');
            $usuari->TELEFON = $request->input('TELEFON');
            $usuari->ADMINISTRADOR = 0;
            if ($usuari->save()) {
                return response()->json(['status' => 'success', 'data' => $usuari], 200);
            }
            return response()->json(['status' => 'error', 'data' => 'Error guardant'], 400);
        }
    }

    /** * @OA\Get(
     *     path="/usuaris/{id}",
     *     operationId="Obtenir usuari",
     *     tags={"Usuaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Mostra un usuari",
     *     description="Retorna un usuari",
     *     @OA\Parameter(
     *     name="id",
     *     description="Usuari ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *      description="Usuari trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     *  )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Comentari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     * )
     *     )
     *
     * )
     */
    public function getUsuari($id)
    {

        try {
            $usuari = Usuari::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $usuari
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap usuari amb la ID proporcionada'
            ], 404);
        }
    }

    /** * @OA\Put(
     *     path="/usuaris/put/{id}",
     *     operationId="Actualitzar usuari",
     *     tags={"Usuaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitza un usuari",
     *     description="Actualitza un usuari",
     *     @OA\Parameter(
     *     name="id",
     *     description="Usuari ID",
     *     required=true,
     *     in="path"
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Usuari a modificar",
     *     @OA\JsonContent(
     *     required={"DNI","NOM_COMPLET","CORREU_ELECTRONIC","CONTRASENYA","TELEFON"},
     *     @OA\Property(property="DNI", type="string", format="string", example="12345678Z"),
     *     @OA\Property(property="NOM_COMPLET", type="string", format="string", example="Nom Cognom"),
     *     @OA\Property(property="CORREU_ELECTRONIC", type="string", format="string", example="patata@gmail.com"),
     *     @OA\Property(property="CONTRASENYA", type="string", format="string", example="12345678"),
     *     @OA\Property(property="TELEFON", type="string", format="string", example="123456789")
     * )
     * ),
     *    @OA\Response(
     *     response=200,
     *     description="Usuari actualitzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     * ),    @OA\Response(
     *     response=404,
     *     description="Usuari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     *
     * ),   @OA\Response(
     *     response=400,
     *     description="Error de usuari",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     * )
     * )
     */
    public function updateUsuaris(Request $request, $id)

    {
        try {
            if ($request->validat_id == $id || $request->esAdministrador) {
                $reglesvalidacio = [
                    'DNI' => 'required|string|max:9',
                    'NOM_COMPLET' => 'required|string|max:50',
                    'CORREU_ELECTRONIC' => 'required|string|max:50|unique:USUARIS,CORREU_ELECTRONIC',
                    'CONTRASENYA' => 'required|string|max:50',
                    'TELEFON' => 'required|string|max:9'
                ];
                $missatges = [
                    'DNI.required' => 'El camp DNI és obligatori.',
                    'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
                    'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
                    'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
                    'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
                    'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
                    'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
                    'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONIC ha de ser una cadena de caràcters.',
                    'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
                    'CORREU_ELECTRONIC.unique' => 'El camp CORREU_ELECTRONIC ja s\'està empleant',
                    'CONTRASENYA.required' => 'El camp CONTRASENYA és obligatori.',
                    'CONTRASENYA.string' => 'El camp CONTRASENYA ha de ser una cadena de caràcters.',
                    'CONTRASENYA.max' => 'El camp CONTRASENYA no pot tenir més de 50 caràcters.',
                    'TELEFON.required' => 'El camp TELEFON és obligatori.',
                    'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
                    'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.'
                ];
                $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 400);
                } else {
                    $usuaris = Usuari::findOrFail($id);
                    $usuaris->DNI = $request->input('DNI');
                    $usuaris->NOM_COMPLET = $request->input('NOM_COMPLET');
                    $usuaris->CORREU_ELECTRONIC = $request->input('CORREU_ELECTRONIC');
                    $usuaris->CONTRASENYA = Hash::make($request->input('CONTRASENYA'));
                    $usuaris->TELEFON = $request->input('TELEFON');
                    $usuaris->save();
                    return response()->json(['status' => 'success', 'data' => $usuaris], 200);
                }
            }else{
                return response()->json(['status' => 'error', 'message' => 'Permisos insuficients']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap usuari amb la ID proporcionada',
            ], 404);
        }
        
    }

    /**
     * @OA\Delete(
     *     path="/usuaris/destroy/{id}",
     *     description="Elimina un usuari",
     *     tags={"Usuaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Elimina un usuari",
     *     @OA\Parameter(
     *     description="ID de l'usuari",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer",
     *     format="int64"
     * )
     * ),
     *    @OA\Response(
     *     response=200,
     *     description="Usuari eliminat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     * ),    @OA\Response(
     *     response=404,
     *     description="Usuari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     *
     * ),   @OA\Response(
     *     response=400,
     *     description="Error de usuari",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Usuari")
     * )
     * )
     * )
     */
    public function deleteUsuari(Request $request, $id)
    {
        try {
            if ($request->validat_id == $id || $request->esAdministrador) {
            $tuples = Usuari::findOrFail($id);
            $tuples->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Usuari eliminat correctament'
            ], 200);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Permisos insuficients']);
        }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap usuari amb la ID proporcionada',
            ], 404);
        }
    }
}
