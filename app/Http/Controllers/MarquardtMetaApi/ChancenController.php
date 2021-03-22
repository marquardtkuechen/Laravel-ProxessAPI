<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\getMMAAufmerksamkeitFormRequest;


class ChancenController extends Controller
{
    public function index()
    {
        return "";
    }

    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/aufmerksamkeit",
     *  tags={"Canchen"},
     *  operationId="getAufmerksamkeit",
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
    public function getAufmerksamkeit(getMMAAufmerksamkeitFormRequest $request)
    {
        //$wawi = EcoroWawi::chanceGetAufmerksamkeit(null);
        //$wawi = EcoroWawi::chanceGetAufmerksamkeit(array('ECORO_643','ECORO_644','ECORO_2837'));
        //dd($request);
        //return ($request->erpFremdKeyList);
        $erpFremdKeyList = isset($request->erpFremdKeyList)?$request->erpFremdKeyList:null;
        $wawi = EcoroWawi::chanceGetAufmerksamkeit($erpFremdKeyList);
        return $wawi;
    }

    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/getHerkunft",
     *  tags={"Canchen"},
     *  operationId="getHerkunft",
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
    public function getHerkunft(getMMAAufmerksamkeitFormRequest $request)
    {
        // ECORO_641, ECORO_642
        $erpFremdKeyList = isset($request->erpFremdKeyList)?$request->erpFremdKeyList:null;
        $wawi = EcoroWawi::chancenGetHerkunft($erpFremdKeyList);
        return $wawi;
    }

    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/getKaufabsicht",
     *  tags={"Canchen"},
     *  operationId="getKaufabsicht",
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
    public function getKaufabsicht(getMMAAufmerksamkeitFormRequest $request)
    {
        // ECORO_654, ECORO_655
        $erpFremdKeyList = isset($request->erpFremdKeyList)?$request->erpFremdKeyList:null;
        $wawi = EcoroWawi::chancenGetKaufabsicht($erpFremdKeyList);
        return $wawi;
    }

    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/getStatus",
     *  tags={"Canchen"},
     *  operationId="getStatus",
     *  summary="-----IN PROGRESS-------",
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
    public function getStatus(getMMAAufmerksamkeitFormRequest $request)
    {
        // 
        $erpFremdKeyList = isset($request->erpFremdKeyList)?$request->erpFremdKeyList:null;
        $wawi = EcoroWawi::chancenGetStatus($erpFremdKeyList);
        return $wawi;
    }

    /**
     * @OA\Get(
     *  path="/mma/v1/stammdaten/chance/getWahrscheinlichkeit",
     *  tags={"Canchen"},
     *  operationId="getWahrscheinlichkeit",
     *  summary="-----IN PROGRESS-------",
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
    public function getWahrscheinlichkeit(getMMAAufmerksamkeitFormRequest $request)
    {
        // 
        $erpFremdKeyList = isset($request->erpFremdKeyList)?$request->erpFremdKeyList:null;
        $wawi = EcoroWawi::chancenGetWahrscheinlichkeit($erpFremdKeyList);
        return $wawi;
    }

    public function checkToken()
    {
        $tockenResult = EcoroWawi::checkToken();
        return $tockenResult;
    }
}
