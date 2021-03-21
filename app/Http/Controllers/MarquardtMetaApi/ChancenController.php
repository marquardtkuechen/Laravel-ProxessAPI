<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\getMMAAufmerksamkeitFormRequest;


class ChancenController extends Controller
{


    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/aufmerksamkeit",
     *  tags={"Canchen"},
     *  operationId="getDocumentFile",
     *  summary="Ruft die Dokument Eigenschaften ab",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
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
    public function index(getMMAAufmerksamkeitFormRequest $request)
    {
        //$wawi = EcoroWawi::chanceGetAufmerksamkeit(null);
        //$wawi = EcoroWawi::chanceGetAufmerksamkeit(array('ECORO_643','ECORO_644','ECORO_2837'));
        //dd($request);
        //return ($request->erpFremdKeyList);
        $wawi = EcoroWawi::chanceGetAufmerksamkeit($request->erpFremdKeyList);
        return $wawi;
    }

    public function checkToken()
    {
        $tockenResult = EcoroWawi::checkToken();
        return $tockenResult;
    }
}
