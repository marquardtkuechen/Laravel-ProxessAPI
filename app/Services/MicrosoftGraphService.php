<?php

namespace App\Services;

use App\Facades\MicrosoftGraphFacade as Graph;
use App\Http\Requests\getDocumentFileRequest;
use App\Http\Requests\getDocumentListRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class MicrosoftGraphService
{

    public function __construct()
    {
        $this->graphUrl = 'https://graph.microsoft.com/v1.0/';
    }

    /**
     * Check Microsoft Graph for token
     * @param String $token
     * @return bool
     */
    public function verifyToken($token)
    {
        $response = Http::withToken($token)->get($this->graphUrl . 'me');
        $userPrincipalName=strtolower($response->json('userPrincipalName'));
        if ($response->status() != 200
            || !$response->json('id')
            || !str_contains($userPrincipalName,'@marquardt-kuechen.de')) {
            return false;
        }
        return true;
    }

    public function getMemberGroups($token): Response
    {
        $response = Http::withToken($token)
            ->get($this->graphUrl . 'memberOf');

        return $response->json();
    }

    public function getRequestBody(Request $request)
    {
        return $request->except('oAuth2accessToken');
    }


}
