<?php

namespace App\Services;

use App\Facades\MicrosoftGraphFacade as Graph;
use App\Http\Requests\deleteDocumentRequest;
use App\Http\Requests\downloadDocumentFileRequest;
use App\Http\Requests\getDocumentFileRequest;
use App\Http\Requests\getDocumentListRequest;
use App\Http\Requests\saveFileRequest;
use App\Http\Requests\updateFileRequest;
use App\Http\Resources\ChanceGetAufmerksamkeitValue;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Marquardt\FileUpload\CustomUploadHandler;
use Marquardt\MHS\ConnectAuftrag;
use Marquardt\MHS\Doc;
use Marquardt\MHS\Ekm;
use Marquardt\Proxess\ArrayOfFieldChange;
use Marquardt\Proxess\BranchCondition;
use Marquardt\Proxess\ChangeDocumentRequest;
use Marquardt\Proxess\CreateDocumentRequest;
use Marquardt\Proxess\FieldCondition;
use Marquardt\Proxess\FileUploadRequest;
use Marquardt\Proxess\FulltextCondition;
use Marquardt\Proxess\GeneralSearch;
use Marquardt\Proxess\GetDatabasesRequest;
use Marquardt\Proxess\GetDocumentRequest;
use Marquardt\Proxess\GetVersionInfoRequest;
use Marquardt\Proxess\NewFileUploadRequest;
use Marquardt\Proxess\ProxessSearchCondition;
use Marquardt\Proxess\ProxessWS;
use Marquardt\Proxess\SearchCondition;
use Marquardt\Proxess\SearchRequest;

use App\Http\Resources\ChanceGetAufmerksamkeitResource;
use App\Http\Resources\ChanceGetHerkunftResource;
use App\Http\Resources\ChanceGetKaufabsichtResource;
use App\Http\Resources\ChancenGetStatusResource;
use App\Http\Resources\ChancenGetWahrscheinlichkeitResource;

class EcoroWawiService
{

    protected Guzzle $http;
    protected $ecoro;

    public function __construct()
    {
        $this->http = new Guzzle(['base_uri' => env('WAWI_URL_INTERN')]);
        $this->ecoro = $this->login();
        //$this->ecoro = $this->checkToken();
        $this->headersJson = [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];

    }

    public function getHeadersJson()
    {
        return [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];
    }

    public function getErpFremdKeyListFilter($erpFremdKeyList)
    {
        return [
            "erpFremdKeyList" => $erpFremdKeyList,
        ];
    }

    public function getInactiveFilter()
    {
        return ["filter" => ["subfilterList" => [[
            "fieldName"      => "inaktiv",
            "referenceValue" => false,
        ]]]];
    }

    public function post($path, array $jsonBody)
    {
        $headers = [
            //'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept' => 'application/json',
        ];
        $response = $this->http->post($path, [
            \GuzzleHttp\RequestOptions::JSON => $jsonBody,

            'headers' => $headers
        ]);
        return $response;
    }

    public function postJson($path, $jsonStringBody)
    {
        $response = $this->http->post($path, [
            'body'    => $jsonStringBody,
            'headers' => $this->getHeadersJson()
        ]);
        return $response;
    }

    public function login()
    {
        $response = Cache::remember('ecoroSession', 30, function () {
            $response = $this->post('/basis/auth/login', [
                "username"  => env('WAWI_USERNAME'),
                "password"  => env('WAWI_PASSWORD'),
                "mandantId" => env('WAWI_TENDANT'),
            ]);
            return json_decode($response->getBody(), true);
        });
        return $response;
    }

    public function checkToken()
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ];
        $response = $this->http->post('/basis/auth/checkToken', [
            'form_params' => [
                'accessToken' => $this->ecoro['accessToken'],
            ],
            'headers'     => $headers
        ]);

        return json_decode($response->getBody(), true);
    }

    public function chanceGetAufmerksamkeit($erpFremdKeyList)
    {
        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $response = $this->postJson(env('WAWI_ChancenAufmerksamkeit_GetListByFilter'), json_encode($this->getInactiveFilter()));
        } else {
            $response = $this->postJson(env('WAWI_ChancenAufmerksamkeit_GetListByErpFremdKeyList'), json_encode($this->getErpFremdKeyListFilter($erpFremdKeyList)));
        }
        $chanceGetAufmerksamkeit = new ChanceGetAufmerksamkeitResource(json_decode($response->getBody(), true));
        return $chanceGetAufmerksamkeit->toArray();
    }

    public function chancenGetHerkunft($erpFremdKeyList)
    {
        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $response = $this->postJson(env('WAWI_ChancenHerkunft_GetListByFilter'), json_encode($this->getInactiveFilter()));
        } else {
            $response = $this->postJson(env('WAWI_ChancenHerkunft_GetListByErpFremdKeyList'), json_encode($this->getErpFremdKeyListFilter($erpFremdKeyList)));
        }
        $chanceGetAufmerksamkeit = new ChanceGetHerkunftResource(json_decode($response->getBody(), true));
        return $chanceGetAufmerksamkeit->toArray();
    }

    public function chancenGetKaufabsicht($erpFremdKeyList)
    {
        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $response = $this->postJson(env('WAWI_ChancenKaufabsicht_GetListByFilter'), json_encode($this->getInactiveFilter()));
        } else {
            $response = $this->postJson(env('WAWI_ChancenKaufabsicht_GetListByErpFremdKeyList'), json_encode($this->getErpFremdKeyListFilter($erpFremdKeyList)));
        }
        $chanceGetAufmerksamkeit = new ChanceGetKaufabsichtResource(json_decode($response->getBody(), true));
        return $chanceGetAufmerksamkeit->toArray();
    }

    public function chancenGetStatus($erpFremdKeyList)
    {
        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $response = $this->postJson(env('WAWI_ChancenStatus_GetListByFilter'), json_encode($this->getInactiveFilter()));
        } else {
            $response = $this->postJson(env('WAWI_ChancenStatus_GetListByErpFremdKeyList'), json_encode($this->getErpFremdKeyListFilter($erpFremdKeyList)));
        }
        $chancenGetStatus = new ChancenGetStatusResource(json_decode($response->getBody(), true));
        return $chancenGetStatus->toArray();
    }

    public function chancenGetWahrscheinlichkeit($erpFremdKeyList)
    {
        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $response = $this->postJson(env('WAWI_ChancenWahrscheinlichkeit_GetListByFilter'), json_encode($this->getInactiveFilter()));
        } else {
            $response = $this->postJson(env('WAWI_ChancenWahrscheinlichkeit_GetListByErpFremdKeyList'), json_encode($this->getErpFremdKeyListFilter($erpFremdKeyList)));
        }
        $chancenGetWahrscheinlichkeit = new ChancenGetWahrscheinlichkeitResource(json_decode($response->getBody(), true));
        return $chancenGetWahrscheinlichkeit->toArray();

    }


}
