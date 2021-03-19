<?php

namespace App\Http\Controllers;

use App\Http\Requests\deleteDocumentRequest;
use App\Http\Requests\downloadDocumentFileRequest;
use App\Http\Requests\getDocumentFileRequest;
use App\Http\Requests\getDocumentListRequest;
use App\Facades\ProxessWSFacade as Proxess;
use App\Http\Requests\saveFileRequest;
use App\Http\Requests\updateFileRequest;
use Illuminate\Http\Request;
use App\Facades\MicrosoftGraphFacade as Graph;
use Marquardt\MHS\Doc;

class ProxessController extends Controller
{
    /** @OA\Info(
     *     title="MMA REST API",
     *     version="0.1",
     *     description="MarquardtMetaAPI",
     *     )
     */

    public function __construct()
    {

    }

    /**
     * @OA\Get(
     *  path="/proxess/v1/",
     *  tags={"Document"},
     *  operationId="getDocumentList",
     *  summary="Liefert eine Liste aller Dokumente für angefragte Kommission",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="kaufvertragNummer",
     *    in="query",
     *    description="",
     *    example="000006",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="kaufvertragNummerPos",
     *    in="query",
     *    description="",
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(getDocumentListRequest $request)
    {

        return Proxess::index($request);
    }


    /**
     * @OA\Post(
     *  path="/proxess/v1/",
     *  tags={"Document"},
     *  operationId="saveFile",
     *  summary="Speichert neue Datei in Dokumentcontainer",
     *     @OA\MediaType(
     *           mediaType="multipart/form-data",
     *     ),
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="DatabaseName",
     *    in="query",
     *    description="",
     *    example="mhs",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="CommissionNr",
     *    in="query",
     *    description="",
     *    example="",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="PosNr",
     *    in="query",
     *    description="",
     *    example="",
     *    required=false,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="ReceiptType",
     *    in="query",
     *    description="Auftragsart Bsp 34 = KV, 304 = KV-Änderung, 4509 = Bestellung",
     *    example="34",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="User",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="Description",
     *    in="query",
     *    description="",
     *    required=false,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="Document",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="binary")
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(saveFileRequest $request)
    {
        return Proxess::save($request);
    }

    /**
     * @OA\Get(
     *  path="/proxess/v1/get",
     *  tags={"Document"},
     *  operationId="getDocumentFile",
     *  summary="Ruft die Dokument Eigenschaften ab",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="DatabaseName",
     *    in="query",
     *    description="",
     *    example="mhs",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="DocumentID",
     *    in="query",
     *    description="",
     *    example="20834984",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="FileID",
     *    in="query",
     *    description="",
     *    example="20834985",
     *
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
    public function show(getDocumentFileRequest $request)
    {
        return Proxess::show($request);
    }
 /**
     * @OA\Get(
     *  path="/proxess/v1/databases",
     *  tags={"Document"},
     *  operationId="getDatabases",
     *  summary="Ruft verfügbare Datenbanken ab",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
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
    public function databases(Request $request)
    {
        return Proxess::getDatabases($request);
    }


    /**
     * @OA\Get(
     *  path="/proxess/v1/download",
     *  tags={"Document"},
     *  operationId="downloadDocumentFile",
     *  summary="Ruft das Dokument zum Download ab",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="DatabaseName",
     *    in="query",
     *    description="",
     *    example="mhs",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="DocumentID",
     *    in="query",
     *    description="",
     *    example="20834984",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="FileID",
     *    in="query",
     *    description="",
     *    example="20834985",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
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
    public function download(downloadDocumentFileRequest $request)
    {
        return Proxess::download($request);
    }


    /**
     * @OA\Patch(
     *  path="/proxess/v1/",
     *  tags={"Document"},
     *  operationId="updateFile",
     *  summary="Aendert eine Datei in Dokumentcontainer",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="DatabaseName",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="CommissionNr",
     *    in="query",
     *    description="",
     *    @OA\Schema(type="integer")
     *  ),
     *  @OA\Parameter(name="PosNr",
     *    in="query",
     *    description="",
     *    @OA\Schema(type="integer")
     *  ),
     *  @OA\Parameter(name="ReceiptType",
     *    in="query",
     *    description="Kann nur verändert werden wenn das Dokument eine Zwischenablage ist. Auftragsart Bsp 34 = KV, 304 = KV-Änderung, 4509 = Bestellung",
     *    example="34",
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="User",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="Description",
     *    in="query",
     *    description="",
     *    required=false,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="DocumentID",
     *    in="query",
     *    description="",
     *    example="20834984",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="FileID",
     *    in="query",
     *    description="",
     *    example="20834985",
     *    @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateFileRequest $request)
    {
        return Proxess::update($request);
    }

    /**
     * @OA\Delete (
     *  path="/proxess/v1/",
     *  tags={"Document"},
     *  operationId="DeleteDocument",
     *  summary="Loescht eine Datei/ ein Dokument",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *  @OA\Parameter(name="DatabaseName",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(name="DocumentID",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Parameter(name="FileID",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="integer",format="int64")
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(deleteDocumentRequest $request)
    {
        return Proxess::destroy($request);
    }

    /**
     * @OA\Get(
     *  path="/proxess/v1/types",
     *  tags={"Document"},
     *  operationId="getDocumentTypes",
     *  summary="Liefert eine Liste aller Dokument-Typen",
     *
     *  @OA\Parameter(name="oAuth2accessToken",
     *    in="query",
     *    description="",
     *    required=true,
     *    @OA\Schema(type="string",format="password")
     *  ),
     *
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctypes(Request $request)
    {
        return Proxess::getTypes($request);
    }

    public function search(Request $request){
        return Proxess::searchDocuments($request);
    }
}
