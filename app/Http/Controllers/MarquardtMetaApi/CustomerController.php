<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarquardtMetaApi\Kunden\getKundenRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Customer",
     *     description="Customer",
     * )
     * /
     * /**
     * @OA\POST(
     *  path="/customer",
     *  tags={"Customer"},
     *  operationId="createCustomer",
     *  summary="",
     *  security={{"bearerAuth": {}}},
     *
     * @OA\RequestBody(@OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *           type="object",
     *           @OA\Property(property="salutationKey", type="string", example=""),
     *           @OA\Property(property="iso2A", type="string", example="DE"),
     *           @OA\Property(property="federalStateKey", type="string", example=""),
     *           @OA\Property(property="name2", type="string", example=""),
     *           @OA\Property(property="name1", type="string", example=""),
     *           @OA\Property(property="strasse", type="string", example=""),
     *           @OA\Property(property="plz", type="string", example=""),
     *           @OA\Property(property="ort", type="string", example=""),
     *           @OA\Property(property="contractList", type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items( type="string" ),
     *                          example={"1","2","147"}),
     *           @OA\Property(property="attentionList", type="array",
     *                          collectionFormat="multi",
     *                          @OA\Items( type="string" ),
     *                          example={"1","2","147"}),
     *        )
     *     ),
     *  ),
     *
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function createCustomer(Request $request){
        $json = '{
            "status": "OK"
        }';
        return response()->json(json_decode($json, true));
    }
}
