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
     *  path="/proxess/v1/email",
     *  tags={"Email"},
     *  operationId="newEmail",
     *  summary="",
     * 
     *  @OA\RequestBody(@OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *           type="object",
     *           @OA\Property(property="marquardtAuftragsNummer", type="string", example="000006"),
     *           @OA\Property(property="posAuftragsNummer", type="string", example="2511"),
     *           @OA\Property(property="file", type="object", 
     *                  @OA\Property(property="fileName", type="string", example="name.pdf"),
     *                  @OA\Property(property="type", type="string", example="application/pdf"),
     *                  @OA\Property(property="size", type="int", example="65989"),
     *                  @OA\Property(property="content", type="string", example=""),
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
        if (is_array($payload)) {
            $marquardtAuftragsNummer = (isset($payload["marquardtAuftragsNummer"]))?$payload["marquardtAuftragsNummer"]:"";
            $posAuftragsNummer = (isset($payload["posAuftragsNummer"]))?$payload["posAuftragsNummer"]:"";
            if (isset($payload["file"]) && is_array($payload["file"])) {
                $fileName = (isset($payload["file"]["name"]))?$payload["file"]["name"]:"";
                $fileType = (isset($payload["file"]["type"]))?$payload["file"]["type"]:"";
                $fileSize = (isset($payload["file"]["size"]))?$payload["file"]["size"]:"";
                $fileContent = (isset($payload["file"]["content"]))?base64_decode($payload["file"]["content"]):"";
            } else {
                return "Error, no file attached!";
            }

            $mhsContents = $this->selectMandant("mae", $marquardtAuftragsNummer);
            $mhsContent = $mhsContents[0];
            //dd($this->selectMandant("mae", $marquardtAuftragsNummer));

            $proxessDoc = $this->prepareProxessDocument ($mhsContent, $marquardtAuftragsNummer, $posAuftragsNummer);

            $this->uploadFile ($proxessDoc, $fileName, $fileContent);

            return response()->json($proxessDoc);

            //return "New: ". $fileName . " - ".$mhsContent["KNAME"];
        } else {
            return "Error, payload!";
        }
    }

    private function uploadFile ($proxessDoc, $fileName, $fileContent) {
        /*$client = new Guzzle(['base_uri' => 'https://api.marquardt-kuechen.de/proxess/v1']);
        $res = $client->request('POST', '/?oAuth2accessToken=MasterKeyMarquardt2021!'.
                                        '&DatabaseName=mhs'.
                                        '&CommissionNr'.'15'.
                                        '&PosNr'.$proxessDoc[""].
                                        ''.
                                        ''.
                                        ''.
                                        ''.
        , [
            //'auth'      => [ env('API_USERNAME'), env('API_PASSWORD') ],
            'multipart' => [
                [
                    'name'     => 'FileContents',
                    'contents' => $fileContent,
                    'filename' => $fileName
                ],
                [
                    'name'     => 'FileInfo',
                    'contents' => json_encode($fileinfo)
                ]
            ],
        ]);*/

        $customer_path_files = '../upl/';
        $fp = fopen($customer_path_files.$fileName, 'w');
        fwrite($fp, $fileContent);
        fclose($fp);

        $path_parts = pathinfo($fileName);
        $extension = strtolower($path_parts['extension']);
/*
        $_REQUEST['docTypeId'] = $proxessDoc['documentTypeID'];
        $_REQUEST['databaseName'] = $proxessDoc['databaseName'];
        $_REQUEST['mhsAuftrag'] = $proxessDoc["documentFields"]["KDNR"];
        $_REQUEST['oriFilename'] = $fileName;
        $_REQUEST['extension'] = 'pdf';
        $_REQUEST['initials'] = '';
        */
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
                    ];

                    $paramArrayOfFieldChange = array_merge($paramOrder, $paramUserFile);
                    /* Search Def */
                    $param = [
                        'LoginToken' => $oLoginToken,
                        'DatabaseName' => $proxessDoc['databaseName'],
                        'DocumentTypeID' => $proxessDoc['documentTypeID'],
                        'DocumentDescription' => $proxessDoc["documentFields"]["KDNR"] . ' # ' . $initials ,
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
        $proxessDocumentInfo["databaseName"] = "MHS";
        $proxessDocumentInfo["documentTypeID"] = "191701";
        $proxessDocumentInfo["documentDescription"] = "AUF POS-".$posAuftragsNummer;
        $proxessDocumentInfo["documentFields"] = array();
        $proxessDocumentInfo["documentFields"]["BELNR"] = $posAuftragsNummer;
        $proxessDocumentInfo["documentFields"]["BELDAT"] = date('d-m-Y h:i:s'); ///TODO
        $proxessDocumentInfo["documentFields"]["LNAME"] = "POS Homeservice GmbH";
        $proxessDocumentInfo["documentFields"]["LORT"] = "Hausen";
        $proxessDocumentInfo["documentFields"]["KREDNR"] = "801880";
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
