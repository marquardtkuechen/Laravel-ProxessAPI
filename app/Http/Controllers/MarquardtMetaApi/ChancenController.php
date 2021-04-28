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
        $erpFremdKeyList = isset($request->erpFremdKeyList) ? $request->erpFremdKeyList : null;
        $wawi = EcoroWawi::chanceGetAufmerksamkeit($erpFremdKeyList);
        return $wawi;
    }

    /**
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getHerkunft(getMMAAufmerksamkeitFormRequest $request)
    {
        // ECORO_641, ECORO_642
        $erpFremdKeyList = isset($request->erpFremdKeyList) ? $request->erpFremdKeyList : null;
        $wawi = EcoroWawi::chancenGetHerkunft($erpFremdKeyList);
        return $wawi;
    }

    /**
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getKaufabsicht(getMMAAufmerksamkeitFormRequest $request)
    {
        // ECORO_654, ECORO_655
        $erpFremdKeyList = isset($request->erpFremdKeyList) ? $request->erpFremdKeyList : null;
        $wawi = EcoroWawi::chancenGetKaufabsicht($erpFremdKeyList);
        return $wawi;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getStatus(getMMAAufmerksamkeitFormRequest $request)
    {
        //
        $erpFremdKeyList = isset($request->erpFremdKeyList) ? $request->erpFremdKeyList : null;
        $wawi = EcoroWawi::chancenGetStatus($erpFremdKeyList);
        return $wawi;
    }

    /**
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getWahrscheinlichkeit(getMMAAufmerksamkeitFormRequest $request)
    {
        //
        $erpFremdKeyList = isset($request->erpFremdKeyList) ? $request->erpFremdKeyList : null;
        $wawi = EcoroWawi::chancenGetWahrscheinlichkeit($erpFremdKeyList);
        return $wawi;
    }

    public function checkToken()
    {
        $tockenResult = EcoroWawi::checkToken();
        return $tockenResult;
    }
}
