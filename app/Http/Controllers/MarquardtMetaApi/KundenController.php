<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarquardtMetaApi\Kunden\getKundenRequest;
use Illuminate\Http\Request;

class KundenController extends Controller
{
    /**
     * @OA\Get(
     *  path="/mma/v1/kunden",
     *  tags={"Kunden"},
     *  operationId="getKunden",
     *  summary="Kundendaten  ermitteln",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="kundenNr",
     *    in="query",
     *    description="",
     *    required=false,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="email",
     *    in="query",
     *    description="",
     *    required=false,
     *    @OA\Schema(type="string",format="email")
     *  ),
     *  @OA\Parameter(name="erpFremdKeyList[]",
     *    in="query",
     *    description="",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ErpFremdKey1"},
     *    ),
     *  ),
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


    public function getKunden(getKundenRequest $request){
        return EcoroWawi::postJson('/wawi/kunde/getListBySearchStringWithFilter','{
  "searchString" : "a.mueller28@web.de",
    "filter": {
        "subfilterList": [
            {
                "fieldName": "inaktiv",
                "referenceValue": 0
            },
            {
                "fieldName": "adresseList.adresse.inaktiv",
                "referenceValue": 0
            },
            {
                "fieldName": "adresseList.adresse.kontaktList.inaktiv",
                "referenceValue": 0
            }
        ]
    }
}');
        return $request;
    }
}
