<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0", 
 *      title="L5 OpenApi documentación de prueba",
 *      description="L5 Swagger OpenApi.",
 * )
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer"
 * )     
 * @OA\Schema(
 *      schema="Error401",
 *      @OA\Property(
 *           property="message",
 *           type="string",
 *           example="Unauthenticated."
 *      ),
 * )
 * @OA\Schema(
 *      schema="Error422",
 *      @OA\Property(
 *           property="message",
 *           type="string",
 *           example="The given data was invalid."
 *      ),
 *      @OA\Property(
 *           property="errors",
 *           type="object",
 *           @OA\Property(
 *                property="atributo 1",
 *                type="array",
 *                @OA\Items(
 *                ),
 *           ),
 *           @OA\Property(
 *                property="atributo 2",
 *                type="array",
 *                @OA\Items(
 *                ),
 *           ),
 *      ),
 * )
 * @OA\Schema(
 *      schema="Error500",
 *      @OA\Property(
 *           property="success",
 *           type="string",
 *           example="False"
 *      ),
 *      @OA\Property(
 *           property="data",
 *           type="string",
 *           example="Error"
 *      ),
 *      @OA\Property(
 *           property="message",
 *           type="string",
 *           example="Especificación del error"
 *      ),
 * )
**/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
