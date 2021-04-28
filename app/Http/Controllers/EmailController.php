<?php

namespace App\Http\Controllers;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\newMailRequest;
use Marquardt\MHS\DbMhs;
use Marquardt\MHS\Doc;

use Marquardt\Proxess\ProxessWS;
use Marquardt\FileUpload\CustomUploadHandler;
use Marquardt\MHS\ConnectAuftrag;
use Marquardt\Proxess\ArrayOfFieldChange;
use Marquardt\Proxess\CreateDocumentRequest;
use Marquardt\Proxess\NewFileUploadRequest;
use Marquardt\Proxess\FileUploadRequest;

use PDO;

class EmailController extends Controller
{
    /**
     *
     *
     * @OA\Post(
     *  path="/documents/email",
     *  tags={"Email"},
     *  operationId="newEmail",
     *  summary="An endpoint to upload email content with attached file.",
     *
     *  @OA\RequestBody(@OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *           type="object",
     *           @OA\Property(property="databaseName", type="string", example="MHS"),
     *           @OA\Property(property="marquardtOrderNumber", type="string", example="000006"),
     *           @OA\Property(property="posOrderNumber", type="string", example="2511"),
     *           @OA\Property(property="LNAME", type="string", example="POS Homeservice GmbH"),
     *           @OA\Property(property="LORT", type="string", example="Hausen"),
     *           @OA\Property(property="KREDNR", type="string", example="801880"),
     *           @OA\Property(property="BELNR", type="string", example="35410-6641032"),
     *           @OA\Property(property="DocDes", type="string", example="AUF POS-35410-6641032"),
     *           @OA\Property(property="VBLATT", type="string", example="MMA"),
     *           @OA\Property(property="file", type="object",
     *                  @OA\Property(property="id", type="string", example=""),
     *                  @OA\Property(property="name", type="string", example="name.pdf"),
     *                  @OA\Property(property="contentType", type="string", example="application/pdf"),
     *                  @OA\Property(property="size", type="int", example="65989"),
     *                  @OA\Property(property="contentBytes", type="string", example=""),
     *                  @OA\Property(property="isInline", type="bool", example=""),
     *                  @OA\Property(property="lastModifiedDateTime", type="string", example=""),
     *           ),
     *        )
     *     ),
     *  ),
     *  security={{"token": {}}},
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
    public function newMail(Request $request){
        $payload = json_decode($request->getContent(), true);
        //dd($payload);
       // dd("json decode");
        if (is_array($payload)) {
            $marquardtAuftragsNummer = (isset($payload["marquardtOrderNumber"]))?$payload["marquardtOrderNumber"]:"";
            $posAuftragsNummer = (isset($payload["posOrderNumber"]))?$payload["posOrderNumber"]:"";
            if (isset($payload["file"]) && is_array($payload["file"])) {
                $fileName = (isset($payload["file"]["name"]))?$payload["file"]["name"]:"";
                $fileType = (isset($payload["file"]["contentType"]))?$payload["file"]["contentType"]:"";
                $fileSize = (isset($payload["file"]["size"]))?$payload["file"]["size"]:"";
                $fileContent = (isset($payload["file"]["contentBytes"]))?base64_decode($payload["file"]["contentBytes"]):"";
            } else {
                return "Error, no file attached!";
            }

            $fileName = preg_replace("/[^a-zA-Z0-9\.]/", "", $fileName);

            $mhsContents = $this->selectMandant("mae", $marquardtAuftragsNummer);
            $mhsContent = $mhsContents[0];
        
            // Extend with request content
            
            if (isset($payload["databaseName"])) {
                $mhsContent["databaseName"] = $payload["databaseName"];
            } else {  return "Error, databaseName not set!"; }
            if (isset($payload["LNAME"])) {
                $mhsContent["LNAME"] = $payload["LNAME"];
            } else {  return "Error, LNAME not set!"; }
            if (isset($payload["LORT"])) {
                $mhsContent["LORT"] = $payload["LORT"];
            } else { return "Error, LORT not set!"; }
            if (isset($payload["KREDNR"])) {
                $mhsContent["KREDNR"] = $payload["KREDNR"];
            } else { return "Error, KREDNR not set!"; }
            if (isset($payload["BELNR"])) {
                $mhsContent["BELNR"] = $payload["BELNR"];
            } else { return "Error, BELNR not set!"; }
            if (isset($payload["DocDes"])) {
                $mhsContent["DocDes"] = $payload["DocDes"];
            } else { return "Error, DocDes not set!"; }
            if (isset($payload["VBLATT"])) {
                $mhsContent["VBLATT"] = $payload["VBLATT"];
            } else { return "Error, VBLATT not set!"; }
            if (isset($payload["documentTypeID"])) {
                $mhsContent["documentTypeID"] = $payload["documentTypeID"];
            } else { return "Error, documentTypeID not set!"; }

            //dd($this->selectMandant("mae", $marquardtAuftragsNummer));

            $proxessDoc = $this->prepareProxessDocument ($mhsContent, $marquardtAuftragsNummer, $posAuftragsNummer);

            $this->uploadFile ($proxessDoc, $fileName, $fileContent);

            //return response()->json($proxessDoc);
            return ""; //response()->json("OK");

            //return "New: ". $fileName . " - ".$mhsContent["KNAME"];
        } else {
            return "Error, payload!";
        }
    }

    private function uploadFile ($proxessDoc, $fileName, $fileContent) {
        $customer_path_files = '../upl/';
        $fp = fopen($customer_path_files.$fileName, 'w');
        fwrite($fp, $fileContent);
        fclose($fp);

        $path_parts = pathinfo($fileName);
        $extension = strtolower($path_parts['extension']);
        $upload = $this->uploadFileToProxess($proxessDoc, $fileName, $fileContent, '', $extension);

    }

    public static function uploadFileToProxess ($proxessDoc, $fileName, $fileContent, $initials, $extension) {
        /* new Proxess Instance */
        $oService = new ProxessWS();
        /* Proxess - LoginToken */
        $oLoginToken = $oService->LoginToken;
        $fileTypesResponse = $oService->GetFileTypes(['LoginToken' => $oLoginToken, 'DatabaseName' => ProxessWS::DB_MHS]);

        foreach($fileTypesResponse->FileTypes->FileType as $value) {
            $accept_file_types[] = $value->Extension;
            $accept_file_typeID[$value->Extension] = $value->Id;
        }

        unset($fileTypesResponse);

        $customer_script_url = '';
        $customer_path_files = '../upl/';
        $customer_path_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/upl/';
        /* def. option for Uploadhandler */
        $options = array(
            'upload_dir' => $customer_path_files,
            'upload_url' => $customer_path_url,
            // 'max_number_of_files' => 10,
            'accept_file_types' => '/\.(' . implode( '|', $accept_file_types ) . ')$/i',
            'user_dirs' => 0
        );

        /* building new upload Instance */
        $upload_handler = new CustomUploadHandler( $options );
        /* only HTTP Methode POST, will trigger an Upload */
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            try {
                /*
                * Iterating through Files from uploadhandler
                * and chunkwise sending to Proxess-WS
                */
                foreach ( $upload_handler->response as $file ) {
                    //$file = $file[0];
                    //$file = (is_array($file)&&isset($file[0]))?$file[0]:$file;
                    /* zweite Check das der Datei Ext. auch erlaubt ist */
                    ( !in_array($extension, $accept_file_types) ) ? exit() : false;
                    /* getting Auftragsinfo for the DMS DB Fields */
                    try {
                        $param = [
                            'DbConnString' => getenv('db_mae_dns')
                            ,'DbConnFetchType' => \PDO::FETCH_ASSOC
                            ,'DbDebug' => 0
                            ,'OrderNumber' => $proxessDoc["documentFields"]["KDNR"]
                            ,'ReturnFormat' => ConnectAuftrag::RETURN_FORMAT_ASSOC
                            ,'DbUser' => getenv('db_mae_user')
                            ,'DbPassword' => getenv('db_mae_pwd')
                        ];

                        $db = new ConnectAuftrag($param);
                        $paramOrder = $db->getOrderInfo();
                    } catch (Exception $e) {
                        echo $e; exit();
                    }

                    /* fields in the DMS DB */
                    $paramUserFile = [
                            //'Creator' => (int)getenv('ekm_default_creater'),
                        'Bearbeiter' => $initials
                            ,'Erfasser' => $initials
                        ,'BELDAT' => date( "d.m.Y H:i:s" )
                        ,'ERFDAT' => date( "d.m.Y H:i:s" )
                        ,'VBLATT' => $proxessDoc["documentFields"]["VBLATT"]
                        ,'KREDNR' => $proxessDoc["documentFields"]["KREDNR"]
                        ,'BELNR' => $proxessDoc["documentFields"]["BELNR"]
                        ,'DocDes' => $proxessDoc["documentFields"]["DocDes"]
                        ,'LNAME' => $proxessDoc["documentFields"]["LNAME"]
                        ,'LORT' => $proxessDoc["documentFields"]["LORT"]
                        ,'KREDNR' => $proxessDoc["documentFields"]["KREDNR"]
                    ];

                    $paramArrayOfFieldChange = array_merge($paramOrder, $paramUserFile);
                    /* Search Def */
                    $param = [
                        'LoginToken' => $oLoginToken,
                        'DatabaseName' => $proxessDoc['databaseName'],
                        'DocumentTypeID' => $proxessDoc['documentTypeID'],
                        'DocumentDescription' => $proxessDoc["documentFields"]["DocDes"] . $initials ,
                        'DocumentFields' => new ArrayOfFieldChange( $paramArrayOfFieldChange ),
                        'DocumentLinks' => null
                    ];
                    /* create Document */
                    $oGetResponse = $oService->CreateDocument( new CreateDocumentRequest( $param ) );
                    /* Reading DocId from Response */
                    $DocId = $oGetResponse->Document->Id;
                    $param = [
                        'LoginToken' => $oLoginToken,
                        'DatabaseName' => $proxessDoc['databaseName'],
                        'DocumentID' => $DocId,
                        'FileID' => 0,
                        'Status' => ProxessWS::TransferStatus_INITIATE,
                        'ChunkID' => 0,
                        'ChunkData' => '',
                        'FileTypeID' => $accept_file_typeID[$extension],
                        'FileDescription' => $fileName
                    ];

                    /* init Fileupload
                    * siehe Seite 150 - Proxess Webservices 2.2.1
                    */
                    $response = $oService->UploadNewFile( new NewFileUploadRequest( $param ) );

                    $buffer;
                    $param[ 'FileID' ] = $response->NewFileID;

                    $handle = fopen( $customer_path_files.$fileName, "rb" );

                    if ( $handle === false ) {
                        return false;
                    } else {
                        /* uploading ther File chunks in CONST CHUNK_SIZE from config.php */
                        while ( !feof( $handle ) ) {
                            $buffer = fread( $handle, ProxessWS::CHUNK_SIZE );
                            $param['Status'] = $response->Status;
                            $param['ChunkID'] = $response->NextChunkID;
                            $param['ChunkData'] = $buffer;

                            $response = $oService->UploadFile( new FileUploadRequest( $param ) );
                            /* hier könnte man auf basis der Response ein Extra Kontrolle Durchführen */
                        }

                        fclose($handle);

                        /* telling the WS that upload ist Finised */
                        $param['Status'] = ProxessWS::TransferStatus_COMPLETE;
                        $param['ChunkID'] = 0;
                        $param['ChunkData'] = '';

                        /* getting response from last Chunk */
                        $response = $oService->UploadFile( new FileUploadRequest( $param ) );

                        /* hier könnte man auf basis der Response ein Extra Kontrolle Durchführen */
                    }
                }

                /* Close WS Connection */
                $oService->LogOut( $oLoginToken );

            } catch ( SoapFault $oSoapFault ) {
                print_r( $oSoapFault );
            } catch ( Exception $oException ) {
                print_r( $oException );
            }


        }

        return (array('State'=>'Success'));
    }

    private function prepareProxessDocument ($mhsContent, $marquardtAuftragsNummer, $posAuftragsNummer) {
        $proxessDocumentInfo = array();

        $proxessDocumentInfo["loginToken"] = "";
        $proxessDocumentInfo["databaseName"] = $mhsContent["databaseName"];
        $proxessDocumentInfo["documentTypeID"] = $mhsContent["documentTypeID"];
        $proxessDocumentInfo["documentDescription"] = $mhsContent["DocDes"];
        $proxessDocumentInfo["documentFields"] = array();
        $proxessDocumentInfo["documentFields"]["BELNR"] = $posAuftragsNummer;
        $proxessDocumentInfo["documentFields"]["BELDAT"] = date('d-m-Y h:i:s');
        $proxessDocumentInfo["documentFields"]["DocDes"] = $mhsContent["DocDes"];
        $proxessDocumentInfo["documentFields"]["LNAME"] = $mhsContent["LNAME"];
        $proxessDocumentInfo["documentFields"]["LORT"] = $mhsContent["LORT"];
        $proxessDocumentInfo["documentFields"]["KREDNR"] = $mhsContent["KREDNR"];
        $proxessDocumentInfo["documentFields"]["VBLATT"] = $mhsContent["VBLATT"];
        $proxessDocumentInfo["documentFields"]["KVNR2"] = $marquardtAuftragsNummer;
        $proxessDocumentInfo["documentFields"]["KDNR"] = $marquardtAuftragsNummer;
        $proxessDocumentInfo["documentFields"]["KNAME"] = $mhsContent["KNAME"];
        $proxessDocumentInfo["documentFields"]["KSTR"] = $mhsContent["KSTR"];
        $proxessDocumentInfo["documentFields"]["KORT"] = $mhsContent["KORT"];
        $proxessDocumentInfo["documentFields"]["Kundenkarte"] = $mhsContent["Kundenkarte"];
        $proxessDocumentInfo["documentFields"]["AuftrDatum"] = $mhsContent["AuftrDatum"];
        $proxessDocumentInfo["documentFields"]["Bearbeiter"] = $mhsContent["Bearbeiter"];
        $proxessDocumentInfo["documentFields"]["KURZZ"] = $mhsContent["KURZZ"];
        $proxessDocumentInfo["documentFields"]["POSITION"] = $mhsContent["POSITION"];

        return $proxessDocumentInfo;
    }

    private function selectMandant($namespace, $marquardtAuftragsNummer) {
        $dbMhs = new DbMhs($namespace);

        $query = "Select a.Mandant ,a.Filiale As POSITION,a.AuftragsDatum As AuftrDatum
                 ,SUBSTRING(t.text,22,3) As KURZZ,SUBSTRING(t.text,22,3) As Bearbeiter
                ,COALESCE(a.Name2ZeileLief,a.Name2Zeile)||', '||COALESCE(Name1ZeileLief,Name1Zeile) As KNAME
                ,COALESCE(a.StrasseLief,a.Strasse) As KSTR
                ,COALESCE(a.OrtLief,a.Ort) As KORT
                ,a.KundenkartenNr As Kundenkarte
                FROM
                MHS.MAUF a INNER JOIN MHS.MTEXT t ON t.Mandant=a.Mandant
                AND t.Textschluessel='MIT'
                AND t.Suchbegriff=COALESCE(a.VerkaeuferNr2,a.VerkaeuferNr1)
                WHERE a.Mandant='0' AND a.AuftragNr='".$marquardtAuftragsNummer."'";

        $mhsCall = $dbMhs->getPDO()->query($query);
        return ($mhsCall->fetchAll(PDO::FETCH_ASSOC));
    }
}
