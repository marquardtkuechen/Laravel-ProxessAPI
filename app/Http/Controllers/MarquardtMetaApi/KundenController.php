<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarquardtMetaApi\Kunden\getKundenRequest;
use Illuminate\Http\Request;

class KundenController extends Controller
{
    /**
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
