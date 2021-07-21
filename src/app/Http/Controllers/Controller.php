<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Gapstars CRM ApplicationAPI",
 *    version="1.0.0",
 * )
 */


/**
 * @OA\Get(
 *   path="/api/customer",
 *   summary="Get Customers",
 *   operationId="testing",
 *   security={  {"sanctum": {}},  },
 *   @OA\Response(response=200, description="successful operation"),
 *   @OA\Response(response=406, description="not acceptable"),
 *   @OA\Response(response=500, description="internal server error"),
 * )
 *
 */

/**
 * @OA\Post (
 *   path="/api/customer",
 *   summary="Post Customers",
 *   operationId="testing",
 *   security={  {"sanctum": {}},  },
 *		@SWG\Parameter(
 *          name="Parameters",
 *          in="body",
 *			description="Update all parameters",
 *          required=true,
 *          type="string",
 *          @SWG\Schema(
 *     @SWG\Property(property="first_name", type="string", example="dimu"),
 *     @SWG\Property(property="last_name", type="string", example="jaya"),
 *     @SWG\Property(property="email", type="string", example="dimujaya@gmail.com"),
 *     @SWG\Property(property="phone_numbers", type="array", example="[{"id": "number0", "label": "Enter phone number", "value" : "0777187147" }]"),
 *      ),
 *   @OA\Response(response=200, description="successful operation"),
 *   @OA\Response(response=406, description="not acceptable"),
 *   @OA\Response(response=500, description="internal server error"),
 * )
 *
 */

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
