<?php

namespace App\Services;

use App\Facades\MicrosoftGraphFacade as Graph;
use App\Http\Requests\deleteDocumentRequest;
use App\Http\Requests\downloadDocumentFileRequest;
use App\Http\Requests\getDocumentFileRequest;
use App\Http\Requests\getDocumentListRequest;
use App\Http\Requests\saveFileRequest;
use App\Http\Requests\updateFileRequest;
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

use App\Http\Resources\ChanceGetAufmerksamkeit;
use App\Http\Resources\ChanceGetHerkunft;
use App\Http\Resources\ChanceGetKaufabsicht;

class EcoroWawiService
{

    protected Guzzle $http;
    protected $ecoro;

    public function __construct()
    {
        $this->http = new Guzzle(['base_uri' => env('WAWI_URL_INTERN')]);
        $this->ecoro = $this->login();
        //$this->ecoro = $this->checkToken();

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
            'headers' => $headers
        ]);

        return json_decode($response->getBody(), true);
    }

    public function chanceGetAufmerksamkeit($erpFremdKeyList)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];

        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $filter = ["filter" => ["subfilterList" => [[
                "fieldName" => "inaktiv", 
                "referenceValue" => false,
            ]]]];

            $response = $this->http->post('/wawi/chancenAufmerksamkeit/getListByFilter', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetAufmerksamkeit(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        } else {
            $filter = [ 
                        "erpFremdKeyList" => $erpFremdKeyList,
                    ];

            $response = $this->http->post('/wawi/chancenAufmerksamkeit/getListByErpFremdKeyList', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetAufmerksamkeit(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        }
       
    }

    public function chancenGetHerkunft($erpFremdKeyList)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];

        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $filter = ["filter" => ["subfilterList" => [[
                "fieldName" => "inaktiv", 
                "referenceValue" => false,
            ]]]];

            $response = $this->http->post('/wawi/chancenHerkunft/getListByFilter', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetHerkunft(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        } else {
            $filter = [ 
                        "erpFremdKeyList" => $erpFremdKeyList,
                    ];

            $response = $this->http->post('/wawi/chancenHerkunft/getListByErpFremdKeyList', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetHerkunft(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        }
       
    }

    public function chancenGetKaufabsicht($erpFremdKeyList)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->ecoro['accessToken'],
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];

        if ($erpFremdKeyList == null || empty($erpFremdKeyList)) {
            $filter = ["filter" => ["subfilterList" => [[
                "fieldName" => "inaktiv", 
                "referenceValue" => false,
            ]]]];

            $response = $this->http->post('/wawi/chancenKaufabsicht/getListByFilter', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetKaufabsicht(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        } else {
            $filter = [ 
                        "erpFremdKeyList" => $erpFremdKeyList,
                    ];

            $response = $this->http->post('/wawi/chancenKaufabsicht/getListByErpFremdKeyList', [
                'body' => json_encode($filter),
                'headers' => $headers
            ]);

            //return json_decode($response->getBody(), true);
            $chanceGetAufmerksamkeit = new ChanceGetKaufabsicht(json_decode($response->getBody(), true));
            return $chanceGetAufmerksamkeit->toArray();
        }
       
    }


}
