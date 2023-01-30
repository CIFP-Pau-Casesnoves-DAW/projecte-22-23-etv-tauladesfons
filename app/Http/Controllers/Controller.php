<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
* @OA\Info(
* title="Projecte ETV", version="1.0",
* description="REST API. Projecte ETV. DAW Client i servidor.",
* @OA\Contact( name="Isaac Palou.",email="isaacpalou@paucasesnovescifp.cat")
* )
*
* @OA\Server(url="http://localhost:8080/api")
*
* @OAS\SecurityScheme(
* securityScheme="bearerAuth",
* type="http",
* scheme="bearer"
* )
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
