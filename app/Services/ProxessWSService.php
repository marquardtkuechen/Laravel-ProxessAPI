<?php

namespace App\Services;

use App\Facades\MicrosoftGraphFacade as Graph;
use App\Http\Requests\deleteDocumentRequest;
use App\Http\Requests\downloadDocumentFileRequest;
use App\Http\Requests\getDocumentFileRequest;
use App\Http\Requests\getDocumentListRequest;
use App\Http\Requests\saveFileRequest;
use App\Http\Requests\updateFileRequest;
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

class ProxessWSService
{


    public function index(getDocumentListRequest $request)
    {
        /**
         * Liefert eine Liste (JSON Array) aller Relevante (Nutzer definiert) Dokumente für angefragte Kommission.
         * Über die DocumentId ist es möglich nachträglich, einzelne Dokumente abzurufen/Downloaden (Offline stellen)
         * Welche Dokumente angeziegt werden muss. Anfangs simpler Administriert über bsp. .ENV
         * nutzerSpediteureDokTyp: LS, LV etc. nutzerMonteureDokTyp: LS, MV etc.
         **/
        $requestFields = $request->validated();
        $_GET['ordernr'] = $requestFields['kaufvertragNummer'];
        $_GET['namespace'] = 'mae';
        $_GET['search'] = '';
        $_GET['sort'] = 'ekmPos';
        $_GET['order'] = 'desc';
        $EKM = Ekm::getJsonList();
        // TODO: getDocumentsList
        return [
            'data'  => [
                $EKM['rows'],
            ],
            'extra' => [
                'method'         => 'getDocumentList',
                'total'          => $EKM['total'],
                'totalFiltered'  => $EKM['totalNotFiltered'],
                'requestsFields' => $requestFields
            ]
        ];
    }

    /**
     * @return array
     */
    public function show(getDocumentFileRequest $request)
    {
        $requestFields = $request->validated();
        $oService = new ProxessWS();
        $parameters = new GetDocumentRequest([
            'LoginToken'   => $oService->LoginToken,
            'DatabaseName' => ($requestFields['DatabaseName']) ? $requestFields['DatabaseName'] : ProxessWS::DB_MHS,
            'DocumentID'   => $requestFields['DocumentID'],
            'FileID'       => (isset($requestFields['FileID'])) ? $requestFields['FileID'] : null
        ]);
        $response = $oService->GetDocument($parameters);


        $oService->LogOut($oService->LoginToken);
        if (isset($requestFields['FileID'])) {
            $data = [];
            foreach ($response->Document->Files as $file) {

                if ($file->Id == $requestFields['FileID']) {
                    $data[] = $file;
                }
            }
        } else {
            $data[] = $response->Document;
        }

        if (count($data) == 0) abort(404, 'Document not found');
        return [
            'data'  =>
                $data
            ,
            'extra' => [
                'method'         => 'getDocumentFile',
                'requestsFields' => $requestFields
            ]
        ];
    }

    /**
     * @return array
     */
    public function download(downloadDocumentFileRequest $request)
    {


        /**
         * Ruft das Dok "physisch" ab, zum darstellen/Runterladen.
         */
        $requestFields = $request->validated();
        // TODO: getDocumentsList
        $_GET['DocumentID'] = $requestFields['DocumentID'];
        $_GET['FileID'] = $requestFields['FileID'];
        $_GET['extension'] = "";
        $fileArray = Doc::downloadFile();
        $fileinfo = new \SplFileInfo($fileArray["name"]);

        $fileExt = isset($_GET['extension']) ? $_GET['extension'] : "";
        if ($fileinfo->getExtension() != $_GET['extension']) {
            $fileArray["name"] .= '.' . $fileExt;
        }
        $headers = [
            'Pragma'                    => 'public',
            'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
            'Cache-Control'             => 'private", false',
            'Content-type'              => $fileArray["type"],
            'Content-Transfer-Encoding' => 'binary',
            'Content-Length'            => mb_strlen($fileArray["content"]),
            'Content-Disposition'       => isset($_GET['browserOpen']) ? 'inline; filename=' . $fileArray["name"] : 'attachment; filename=' . $fileArray["name"],
        ];

        return response($fileArray["content"])->withHeaders($headers);
        /* return [
             'data'  => [

             ],
             'extra' => [
                 'method'         => 'getDocumentFile',
                 'requestsFields' => $requestFields
             ]
         ];*/
    }

    /**
     * @return array
     */
    public function save(saveFileRequest $request)
    {


        $requestFields = $request->validated();

        $_REQUEST['docTypeId'] = $requestFields['ReceiptType'];
        $_REQUEST['databaseName'] = $requestFields['DatabaseName'];
        $_REQUEST['mhsAuftrag'] = $requestFields['CommissionNr'];
        $_REQUEST['oriFilename'] = 'tmp';
        $_REQUEST['initials'] = '';
        $upload = Doc::uploadFile();


        return [
            'data'  => [
                $upload
            ],
            'extra' => [
                'method'         => 'saveFile',
                'requestsFields' => $requestFields
            ]
        ];
    }

    /**
     * @return array
     */
    public function update(updateFileRequest $request)
    {

        /**
         * Offnet ein Dokument-Container und speichert die Datei.
         * Folgende Felder sind Pflicht beim Speichernr:
         * DocumentId
         * Kommissionsnr.
         * Posnr. (Option)
         * Belegtype
         * Nutzer
         * Beschreibung (Option)
         *
         * Bei Update dazu noch:
         * DocumentId
         * FileId
         */
        $requestFields = $request->validated();
        $oService = new ProxessWS();
        $paramUserFile = [
            //'Creator' => (int)getenv('ekm_default_creater'),
            //'POSITION'    => $requestFields[''],
            //'IDNR'        => $requestFields[''],
            'BELNR'  => $requestFields['CommissionNr'],
            //'LIEFNR'      => $requestFields[''],
            //'LNAME'       => $requestFields[''],
            //'LORT'        => $requestFields[''],
            //'KORT'        => $requestFields[''],
            //'KSTR'        => $requestFields[''],
            //'KDNR'        => $requestFields[''],
            'POS'    => $requestFields['PosNr'],
            'VBLATT'      => 'API Info',
            //'BBLATT'      => $requestFields[''],
            //'KURZZ'       => $requestFields[''],
            //'Bearbeiter'  => $requestFields[''],
            //'KVNR2'       => $requestFields[''],
            //'KNAME'       => $requestFields[''],
            //'AuftrDatum'  => $requestFields[''],
            //'Kundenkarte' => $requestFields[''],
            //'BELDAT' => date("d.m.Y H:i:s"),
            'BELDAT' => date("Y-m-d H:i:s"),
            'ERFDAT' => date("d.m.Y H:i:s")
        ];
        // $paramArrayOfFieldChange = array_merge($paramOrder, $paramUserFile);

        $parameters = [
            'LoginToken'     => $oService->LoginToken,
            'DatabaseName'   => ($requestFields['DatabaseName']) ? $requestFields['DatabaseName'] : ProxessWS::DB_MHS,
            'DocumentID'     => $requestFields['DocumentID'],
            'FileID'         => (isset($requestFields['FileID'])) ? $requestFields['FileID'] : null,
            'Fields'         => new ArrayOfFieldChange($paramUserFile),
            'Description'    => $requestFields['Description'],
            'Links'          => '',
            'DocumentTypeID' => $requestFields['ReceiptType'],

        ];
        $changeDocumentRequest = new ChangeDocumentRequest($parameters);


        $response = $oService->ChangeDocument($changeDocumentRequest);
        $oService->LogOut($oService->LoginToken);

        //'DocumentFields' => new ArrayOfFieldChange($paramArrayOfFieldChange),

        return [
            'data'  => [
                $response
            ],
            'extra' => [
                'method'         => 'updateDocument',
                'requestsFields' => $requestFields
            ]
        ];
    }

    /**
     * @return array
     */
    public function destroy(deleteDocumentRequest $request)
    {
        /**
         * Löscht ein bestimten datei (FileId)
         * Die Dateien sind im Dokument Container gebündelt (DocumentId).
         * Da aus ergibt sich dann 2 Situationen:
         * 1. Dokument Container (DocumentId) beinhaltet >1 Datei (FileId´s ) -
         * Hier darf nur die Angewählte Datei Gelöscht werden (=FileId)
         * 2. Dokument Container (DocumentId) enthält 1 Datei - dann muss erst Die Datei (FileID) gelöscht werden und dann der Dokument Container (DocumentId)
         */


        $requestFields = $request->validated();


        $oService = new ProxessWS();

        $response = $oService->DeleteFile([
            'LoginToken'   => $oService->LoginToken,
            'DatabaseName' => ProxessWS::DB_MHS,
            'DocumentID'   => $requestFields['DocumentID'],
            'FileID'       => $requestFields['FileID']
        ]);


        $oService->LogOut($oService->LoginToken);

        return [
            'data'  => [
                $response
            ],
            'extra' => [
                'method'         => 'deleteDocument',
                'requestsFields' => $requestFields
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTypes(Request $request)
    {
        $data = Cache::remember('documentTypes', 600, function () {
            return Doc::getTypes();
        });
        return [
            'data'  => [
                $data

            ],
            'extra' => [
                'method'         => 'getDocumentTypes',
                'requestsFields' => $request->except('oAuth2accessToken')
            ]
        ];
    }  /**
     * @return array
     */
    public function getDatabases(Request $request)
    {
        $data = Cache::remember('databases', 1, function () {
              $oService = new ProxessWS();
            return $oService->GetDatabases(new GetDatabasesRequest(['LoginToken'=>$oService->LoginToken]));
        });
        return [
            'data'  => [
                $data

            ],
            'extra' => [
                'method'         => 'getDatabases',
                'requestsFields' => $request->except('oAuth2accessToken')
            ]
        ];
    }

    public function searchDocuments(Request $request)
    {
        $oService = new ProxessWS();
        $a_Parameters['FieldName'] = 'KORT';
        $a_Parameters['Comparator'] = 'isLike';
        $a_Parameters['Value'] = 'Monsterhausen';
        $fieldConditions = new FieldCondition($a_Parameters);
        $branchParameters = ['Conjunction' => 'And',
                             'Conditions'  => $fieldConditions,
        ];
        $branchConditions = new BranchCondition($branchParameters);
$soapXML = '<RootCondition type="BranchCondition">
                          <Conjunction>And</Conjunction>
                          <Conditions>
                              <SearchCondition type="FieldCondition">
                                  <FieldName>KORT</FieldName>
                                  <Comparator>IsLike</Comparator>
                                  <Value>Monsterhausen</Value>
                              </SearchCondition>
                          </Conditions>
                      </RootCondition>';
             $fulltextXML = '<RootCondition type="FulltextCondition">
                              <SearchMode>DocumentFields</SearchMode>
                              <QueryString>Rechnung</QueryString>
                            </RootCondition>';

   // return json_encode($oService->GetVersionInfo(new GetVersionInfoRequest([])));
        $GeneralSearch = [
            'DatabaseName'  => ProxessWS::DB_MHS,
            'MaxHits'       => 10,
            'HitsPerPage'   => 1,
            'RootCondition' => $branchConditions,
            'OrderBy'       => null
        ];

        $param = [
            'LoginToken' => $oService->LoginToken,
            'ChunkID'    => 0,
            'Query'      => new GeneralSearch($GeneralSearch),
            'QueryKey'   => '',
            'Status'     => ProxessWS::TransferStatus_INITIATE
        ];


        $response = $oService->Query(new SearchRequest($param));

        return [
            'data'  => [
                $response
            ],
            'extra' => [
                'method'         => 'getDocumentTypes',
                'requestsFields' => $request->except('oAuth2accessToken')
            ]
        ];
    }
}
