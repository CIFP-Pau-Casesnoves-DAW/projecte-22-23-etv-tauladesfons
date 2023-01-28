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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/usuaris",
     *     summary="Llista tots els usuaris",
     *     tags={"Usuaris"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="result", type="array",@OA\Items(
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
     *     @OA\Property(property="TELEFON", type="string", example="12345678Z"),
     *     @OA\Property(property="ADMINISTRADOR", type="boolean", example="true")
     *
     * )
     */
    public function getUsuaris()
    {
        $tuples=Usuari::all();
         return response()->json(['status'=>'success', 'result' => $tuples],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /**
     * @OA\Post(
     *     path="/usuaris",
     *     summary="Crear un usuari",
     *     tags={"Usuaris"},
     *     @OA\RequestBody(
     *         description="Usuari a crear",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="ID_USUARI", type="int", example="123"),
     *             @OA\Property(property="DNI", type="string", example="12345678Z"),
     *             @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *             @OA\Property(property="CORREU_ELECTRONIC", type="string", example="perepujol@gmail.com"),
     *             @OA\Property(property="CONTRASENYA", type="string", example="patata"),
     *             @OA\Property(property="TELEFON", type="string", example="123456789"),
     *             @OA\Property(property="ADMINISTRADOR", type="boolean", example="false")
     *        )
     *    ),
     *     @OA\Response(
     *     response=201,
     *     description="Creat correctament",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="array",@OA\Items(
     *     @OA\Property(property="ID_USUARI", type="integer", example=1),
     *     @OA\Property(property="DNI", type="string", example="12345678Z"),
     *     @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *     @OA\Property(property="CORREU_ELECTRONIC", type="string", example="patata@gmail.com"),
     *     @OA\Property(property="CONTRASENYA", type="string", example="patata"),
     *     @OA\Property(property="TELEFON", type="string", example="123456789"),
     *     @OA\Property(property="ADMINISTRADOR", type="boolean", example="false")
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
            'CONTRASENYA.required' => 'El camp CONTRASENYA és obligatori.',
            'CONTRASENYA.string' => 'El camp CONTRASENYA ha de ser una cadena de caràcters.',
            'CONTRASENYA.max' => 'El camp CONTRASENYA no pot tenir més de 50 caràcters.',
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
        $usuaris->CONTRASENYA=Hash::make($request->input('CONTRASENYA'));
        $usuaris->TELEFON=$request->input('TELEFON');
        $usuaris->ADMINISTRADOR=$request->input('ADMINISTRADOR');
        $usuaris->save();
        return response()->json(['status'=>'success', 'result' => 'Nou usuari creat'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /** * @OA\Get(
     *      path="/usuaris/{id}",
     *     operationId="Obtenir usuari",
     *     tags={"Usuaris"},
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
            $usuaris=Usuari::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $usuaris],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat l\'usuari'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /** * @OA\Put(
     *      path="/usuaris/put/{id}",
     *     operationId="Actualitzar usuari",
     *     tags={"Usuaris"},
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
     *     required={"ID_USUARI","DNI","NOM_COMPLET","CORREU_ELECTRONIC","CONTRASENYA","TELEFON","ADMINISTRADOR"},
     *     @OA\Property(property="ID_USUARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="DNI", type="string", format="string", example="12345678Z"),
     *     @OA\Property(property="NOM_COMPLET", type="string", format="string", example="Nom Cognom"),
     *     @OA\Property(property="CORREU_ELECTRONIC", type="string", format="string", example="patata@gmail.com"),
     *     @OA\Property(property="CONTRASENYA", type="string", format="string", example="12345678"),
     *     @OA\Property(property="TELEFON", type="string", format="string", example="123456789"),
     *     @OA\Property(property="ADMINISTRADOR", type="boolean", format="boolean", example=true)
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
            'CONTRASENYA.required' => 'El camp CONTRASENYA és obligatori.',
            'CONTRASENYA.string' => 'El camp CONTRASENYA ha de ser una cadena de caràcters.',
            'CONTRASENYA.max' => 'El camp CONTRASENYA no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'ADMINISTRADOR.required' => 'El camp ADMINISTRADOR és obligatori.',
            'ADMINISTRADOR.boolean' => 'El camp ADMINISTRADOR ha de ser un booleà.'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $usuaris = Usuari::findOrFail($id);
            $usuaris->ID_USUARI=$request->input('ID_USUARI');
            $usuaris->DNI=$request->input('DNI');
            $usuaris->NOM_COMPLET=$request->input('NOM_COMPLET');
            $usuaris->CORREU_ELECTRONIC=$request->input('CORREU_ELECTRONIC');
            $usuaris->CONTRASENYA=Hash::make($request->input('CONTRASENYA'));
            $usuaris->TELEFON=$request->input('TELEFON');
            $usuaris->ADMINISTRADOR=$request->input('ADMINISTRADOR');
            $usuaris->save();
            return response()->json(['status' => 'Usuari actualitzat correctament'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/usuaris/destroy/{id}",
     *     description="Elimina un usuari",
     *     tags={"Usuaris"},
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
    public function deleteUsuari($id)
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
