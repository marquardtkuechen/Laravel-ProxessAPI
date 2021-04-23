<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KeyController extends Controller
{

    public function applyFilter($json, $request,$term)
    {
        $json = json_decode($json, true);
        if ($request->input($term.'KeyList') != null) {
            $json['valueList'] = Arr::where($json['valueList'], function ($val) use ($request, $term) {
                return (in_array($val[$term.'Key'], $request->input($term.'KeyList')));
            });
        }
        $json['to']=$json['totalNumberOfElements']=count($json['valueList'] );
        return response()->json($json);
    }

    /**
     * @OA\Tag(
     *     name="Keys",
     *     description="Find option data for key fields",
     * )
     * /
     *
     * /**
     * @OA\Get(
     *  path="/keys/attention",
     *  tags={"Keys"},
     *  operationId="getAttentionKey",
     *  summary="liest alle oder einzelne Aufmerksamkeits ErpFremdKey und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="attentionKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_643","ECORO_644"},
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
    public function getAttentionKeys(Request $request)
    {
        $json = '{
            "status": "OK",
            "errorNumber": null,
            "errorMessage": null,
            "typeName": "attentionDTO",
            "totalNumberOfElements": 6,
            "from": 0,
            "to": 6,
            "valueList": [
                {
                    "attentionKey": "ECORO_643",
                    "suchbegriff": "1",
                    "sort": 1,
                    "value": "Aufmerksamkeit 1",
                    "ecoroTextschluessel": 17
                },
                {
                    "attentionKey": "ECORO_644",
                    "suchbegriff": "2",
                    "sort": 2,
                    "value": "Aufmerksamkeit 2",
                    "ecoroTextschluessel": 17
                },
                {
                    "attentionKey": "ECORO_2837",
                    "suchbegriff": "3",
                    "sort": 3,
                    "value": "Terminwunsch",
                    "ecoroTextschluessel": 17
                },
                {
                    "attentionKey": "ECORO_2838",
                    "suchbegriff": "4",
                    "sort": 4,
                    "value": "Kataloganforderung",
                    "ecoroTextschluessel": 17
                },
                {
                    "attentionKey": "ECORO_2839",
                    "suchbegriff": "5",
                    "sort": 5,
                    "value": "Event-Buchung",
                    "ecoroTextschluessel": 17
                },
                {
                    "attentionKey": "ECORO_2840",
                    "suchbegriff": "6",
                    "sort": 6,
                    "value": "Kontaktaufnahme",
                    "ecoroTextschluessel": 17
                }
            ]
            }';

        return $this->applyFilter($json, $request, 'attention');
    }

    /**
     * @OA\Get(
     *  path="/keys/country",
     *  tags={"Keys"},
     *  operationId="getCountryKey",
     *  summary="liest alle oder einzelne Laender ErpFremkey und Bez. Aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="countryKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"1","2","147"},
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
    public function getCountryKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
	"typeName": "countryDTO",
    "totalNumberOfElements": 61,
    "from": 0,
    "to": 61,
    "valueList": [
        {
            "countryKey": "1",
            "value": "Deutschland",
            "iso2A": "DE",
            "iso3A": "DEU",
            "iso3n": 276,
            "isoZip": "DE",
            "currency": "EUR",
            "phonePrefix": 49
        },
        {
            "countryKey": "2",
            "value": "Frankreich",
            "iso2A": "FR",
            "iso3A": "FRA",
            "iso3n": 250,
            "isoZip": "FR",
            "currency": "EUR",
            "phonePrefix": 33
        },
        {
            "countryKey": "3",
            "value": "Italien",
            "iso2A": "IT",
            "iso3A": "ITA",
            "iso3n": 380,
            "isoZip": "IT",
            "currency": "EUR",
            "phonePrefix": 39
        },
        {
            "countryKey": "4",
            "value": "England",
            "iso2A": "GB",
            "iso3A": "GBR",
            "iso3n": 826,
            "isoZip": "GB",
            "currency": "GBP",
            "phonePrefix": 44
        },
        {
            "countryKey": "5",
            "value": "Niederlande",
            "iso2A": "NL",
            "iso3A": "NLD",
            "iso3n": 528,
            "isoZip": "NL",
            "currency": "EUR",
            "phonePrefix": 31
        },
        {
            "countryKey": "6",
            "value": "Vereinigte Staaten von Amerika",
            "iso2A": "US",
            "iso3A": "USA",
            "iso3n": 840,
            "isoZip": "US",
            "currency": "USD",
            "phonePrefix": null
        },
        {
            "countryKey": "7",
            "value": "Dänemark",
            "iso2A": "DK",
            "iso3A": "DNK",
            "iso3n": 208,
            "isoZip": "DK",
            "currency": "DKK",
            "phonePrefix": 45
        },
        {
            "countryKey": "8",
            "value": "Belgien",
            "iso2A": "BE",
            "iso3A": "BEL",
            "iso3n": 56,
            "isoZip": "BE",
            "currency": "EUR",
            "phonePrefix": 32
        },
        {
            "countryKey": "9",
            "value": "Österreich",
            "iso2A": "AT",
            "iso3A": "AUT",
            "iso3n": 40,
            "isoZip": "AT",
            "currency": "EUR",
            "phonePrefix": 43
        },
        {
            "countryKey": "10",
            "value": "Luxemburg",
            "iso2A": "LU",
            "iso3A": "LUX",
            "iso3n": 442,
            "isoZip": "LU",
            "currency": "EUR",
            "phonePrefix": 52
        },
        {
            "countryKey": "11",
            "value": "Finnland",
            "iso2A": "FI",
            "iso3A": "FIN",
            "iso3n": 246,
            "isoZip": "FI",
            "currency": "EUR",
            "phonePrefix": 358
        },
        {
            "countryKey": "12",
            "value": "Irland",
            "iso2A": "IE",
            "iso3A": "IRL",
            "iso3n": 372,
            "isoZip": "IE",
            "currency": "EUR",
            "phonePrefix": 44
        },
        {
            "countryKey": "13",
            "value": "Portugal",
            "iso2A": "PT",
            "iso3A": "PRT",
            "iso3n": 620,
            "isoZip": "PT",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "14",
            "value": "Spanien",
            "iso2A": "ES",
            "iso3A": "ESP",
            "iso3n": 724,
            "isoZip": "ES",
            "currency": "EUR",
            "phonePrefix": 34
        },
        {
            "countryKey": "15",
            "value": "Schweiz",
            "iso2A": "CH",
            "iso3A": "CHE",
            "iso3n": 756,
            "isoZip": "CH",
            "currency": "CHF",
            "phonePrefix": 41
        },
        {
            "countryKey": "16",
            "value": "Tschechische Republik",
            "iso2A": "CZ",
            "iso3A": "CZE",
            "iso3n": 203,
            "isoZip": "CZ",
            "currency": "CZK",
            "phonePrefix": 1
        },
        {
            "countryKey": "17",
            "value": "Bulgarien",
            "iso2A": "BG",
            "iso3A": "BGR",
            "iso3n": 100,
            "isoZip": "BG",
            "currency": "BGN",
            "phonePrefix": 59
        },
        {
            "countryKey": "18",
            "value": "Rumänien",
            "iso2A": "RO",
            "iso3A": "ROU",
            "iso3n": 642,
            "isoZip": "RO",
            "currency": "RON",
            "phonePrefix": 40
        },
        {
            "countryKey": "19",
            "value": "Estland",
            "iso2A": "EE",
            "iso3A": "EST",
            "iso3n": 233,
            "isoZip": "EE",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "20",
            "value": "Griechenland",
            "iso2A": "GR",
            "iso3A": "GRC",
            "iso3n": 300,
            "isoZip": "GR",
            "currency": "EUR",
            "phonePrefix": 30
        },
        {
            "countryKey": "21",
            "value": "Lettland",
            "iso2A": "LV",
            "iso3A": "LVA",
            "iso3n": 428,
            "isoZip": "LV",
            "currency": "EUR",
            "phonePrefix": 371
        },
        {
            "countryKey": "22",
            "value": "Litauen",
            "iso2A": "LT",
            "iso3A": "LTU",
            "iso3n": 440,
            "isoZip": "LT",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "23",
            "value": "Malta",
            "iso2A": "MT",
            "iso3A": "MLT",
            "iso3n": 470,
            "isoZip": "MT",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "24",
            "value": "Polen",
            "iso2A": "PL",
            "iso3A": "POL",
            "iso3n": 616,
            "isoZip": "PL",
            "currency": "PLN",
            "phonePrefix": 48
        },
        {
            "countryKey": "25",
            "value": "Schweden",
            "iso2A": "SE",
            "iso3A": "SWE",
            "iso3n": 752,
            "isoZip": "SE",
            "currency": "SEK",
            "phonePrefix": 46
        },
        {
            "countryKey": "26",
            "value": "Slowakei",
            "iso2A": "SK",
            "iso3A": "SVK",
            "iso3n": 703,
            "isoZip": "SK",
            "currency": "EUR",
            "phonePrefix": 2
        },
        {
            "countryKey": "27",
            "value": "Slowenien",
            "iso2A": "SI",
            "iso3A": "SVN",
            "iso3n": 705,
            "isoZip": "SI",
            "currency": "EUR",
            "phonePrefix": 386
        },
        {
            "countryKey": "28",
            "value": "Ungarn",
            "iso2A": "HU",
            "iso3A": "HUN",
            "iso3n": 348,
            "isoZip": "HU",
            "currency": "HUF",
            "phonePrefix": 36
        },
        {
            "countryKey": "29",
            "value": "Zypern",
            "iso2A": "CY",
            "iso3A": "CYP",
            "iso3n": 196,
            "isoZip": "CY",
            "currency": "EUR",
            "phonePrefix": 357
        },
        {
            "countryKey": "29",
            "value": "Norwegen",
            "iso2A": "NO",
            "iso3A": "NOR",
            "iso3n": 578,
            "isoZip": "NO",
            "currency": "NOK",
            "phonePrefix": 47
        },
        {
            "countryKey": "66",
            "value": "Volksrepublik China",
            "iso2A": "CN",
            "iso3A": "CHN",
            "iso3n": 156,
            "isoZip": "CN",
            "currency": "CNY",
            "phonePrefix": 86
        },
        {
            "countryKey": "83",
            "value": "Australien",
            "iso2A": "AU",
            "iso3A": "AUS",
            "iso3n": 36,
            "isoZip": "AU",
            "currency": "AUD",
            "phonePrefix": null
        },
        {
            "countryKey": "88",
            "value": "Weißrussland",
            "iso2A": "BY",
            "iso3A": "BLR",
            "iso3n": 112,
            "isoZip": "BY",
            "currency": "BYN",
            "phonePrefix": null
        },
        {
            "countryKey": "95",
            "value": "Bosnien und Herzegowina",
            "iso2A": "BA",
            "iso3A": "BIH",
            "iso3n": 70,
            "isoZip": "BA",
            "currency": "BAM",
            "phonePrefix": null
        },
        {
            "countryKey": "116",
            "value": "Färöer",
            "iso2A": "FO",
            "iso3A": "FRO",
            "iso3n": 234,
            "isoZip": "FO",
            "currency": "DKK",
            "phonePrefix": null
        },
        {
            "countryKey": "125",
            "value": "Gibraltar",
            "iso2A": "GI",
            "iso3A": "GIB",
            "iso3n": 292,
            "isoZip": "GI",
            "currency": "GIP",
            "phonePrefix": null
        },
        {
            "countryKey": "131",
            "value": "Guernsey",
            "iso2A": "GG",
            "iso3A": "GGY",
            "iso3n": 831,
            "isoZip": "GG",
            "currency": "GBP",
            "phonePrefix": null
        },
        {
            "countryKey": "138",
            "value": "Hongkong",
            "iso2A": "HK",
            "iso3A": "HKG",
            "iso3n": 344,
            "isoZip": "HK",
            "currency": "HKD",
            "phonePrefix": null
        },
        {
            "countryKey": "140",
            "value": "Indonesien",
            "iso2A": "ID",
            "iso3A": "IDN",
            "iso3n": 360,
            "isoZip": "ID",
            "currency": "IDR",
            "phonePrefix": null
        },
        {
            "countryKey": "145",
            "value": "Israel",
            "iso2A": "IL",
            "iso3A": "ISR",
            "iso3n": 376,
            "isoZip": "IL",
            "currency": "ILS",
            "phonePrefix": null
        },
        {
            "countryKey": "147",
            "value": "Japan",
            "iso2A": "JP",
            "iso3A": "JPN",
            "iso3n": 392,
            "isoZip": "JP",
            "currency": "JPY",
            "phonePrefix": null
        },
        {
            "countryKey": "149",
            "value": "Jersey",
            "iso2A": "JE",
            "iso3A": "JEY",
            "iso3n": 832,
            "isoZip": "JE",
            "currency": "GBP",
            "phonePrefix": null
        },
        {
            "countryKey": "154",
            "value": "Kanada",
            "iso2A": "CA",
            "iso3A": "CAN",
            "iso3n": 124,
            "isoZip": "CA",
            "currency": "CAD",
            "phonePrefix": null
        },
        {
            "countryKey": "157",
            "value": "Katar",
            "iso2A": "QA",
            "iso3A": "QAT",
            "iso3n": 634,
            "isoZip": "QA",
            "currency": "QAR",
            "phonePrefix": null
        },
        {
            "countryKey": "168",
            "value": "Kroatien",
            "iso2A": "HR",
            "iso3A": "HRV",
            "iso3n": 191,
            "isoZip": "HR",
            "currency": "HRK",
            "phonePrefix": null
        },
        {
            "countryKey": "170",
            "value": "Kuwait",
            "iso2A": "KW",
            "iso3A": "KWT",
            "iso3n": 414,
            "isoZip": "KW",
            "currency": "KWD",
            "phonePrefix": null
        },
        {
            "countryKey": "176",
            "value": "Liechtenstein",
            "iso2A": "LI",
            "iso3A": "LIE",
            "iso3n": 438,
            "isoZip": "LI",
            "currency": "CHF",
            "phonePrefix": null
        },
        {
            "countryKey": "183",
            "value": "Marokko",
            "iso2A": "MA",
            "iso3A": "MAR",
            "iso3n": 504,
            "isoZip": "MA",
            "currency": "MAD",
            "phonePrefix": null
        },
        {
            "countryKey": "192",
            "value": "Moldawien",
            "iso2A": "MD",
            "iso3A": "MDA",
            "iso3n": 498,
            "isoZip": "MD",
            "currency": "MDL",
            "phonePrefix": null
        },
        {
            "countryKey": "194",
            "value": "Montenegro",
            "iso2A": "ME",
            "iso3A": "MNE",
            "iso3n": 499,
            "isoZip": "ME",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "202",
            "value": "Neuseeland",
            "iso2A": "NZ",
            "iso3A": "NZL",
            "iso3n": 554,
            "isoZip": "NZ",
            "currency": "NZD",
            "phonePrefix": null
        },
        {
            "countryKey": "223",
            "value": "Russische Föderation",
            "iso2A": "RU",
            "iso3A": "RUS",
            "iso3n": 643,
            "isoZip": "RU",
            "currency": "RUB",
            "phonePrefix": null
        },
        {
            "countryKey": "230",
            "value": "Saudi-Arabien",
            "iso2A": "SA",
            "iso3A": "SAU",
            "iso3n": 682,
            "isoZip": "SA",
            "currency": "SAR",
            "phonePrefix": null
        },
        {
            "countryKey": "232",
            "value": "Serbien",
            "iso2A": "RS",
            "iso3A": "SRB",
            "iso3n": 688,
            "isoZip": "RS",
            "currency": "RSD",
            "phonePrefix": null
        },
        {
            "countryKey": "236",
            "value": "Singapur",
            "iso2A": "SG",
            "iso3A": "SGP",
            "iso3n": 702,
            "isoZip": "SG",
            "currency": "SGD",
            "phonePrefix": null
        },
        {
            "countryKey": "245",
            "value": "Südafrika",
            "iso2A": "ZA",
            "iso3A": "ZAF",
            "iso3n": 710,
            "isoZip": "ZA",
            "currency": "ZAR",
            "phonePrefix": null
        },
        {
            "countryKey": "262",
            "value": "Türkei",
            "iso2A": "TR",
            "iso3A": "TUR",
            "iso3n": 792,
            "isoZip": "TR",
            "currency": "TRY",
            "phonePrefix": null
        },
        {
            "countryKey": "272",
            "value": "Vatikanstadt",
            "iso2A": "VA",
            "iso3A": "VAT",
            "iso3n": 336,
            "isoZip": "VA",
            "currency": "EUR",
            "phonePrefix": null
        },
        {
            "countryKey": "274",
            "value": "Vereinigte Arabische Emirate",
            "iso2A": "AE",
            "iso3A": "ARE",
            "iso3n": 784,
            "isoZip": "AE",
            "currency": "AED",
            "phonePrefix": null
        },
        {
            "countryKey": "275",
            "value": "Vietnam",
            "iso2A": "VN",
            "iso3A": "VNM",
            "iso3n": 704,
            "isoZip": "VN",
            "currency": "VND",
            "phonePrefix": null
        },
        {
            "countryKey": "281",
            "value": "Kosovo",
            "iso2A": "XK",
            "iso3A": "XKX",
            "iso3n": -1,
            "isoZip": "KO",
            "currency": "EUR",
            "phonePrefix": null
        }
    ]
}';
        return $this->applyFilter($json, $request, 'country');
    }

    /**
     * @OA\Get(
     *  path="/keys/serviceError",
     *  tags={"Keys"},
     *  operationId="getServiceErrorKeys",
     *  summary="liest alle oder einzelne Kundendienst Fehlerschluessel erpFremdKey und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="serviceErrorTextKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_101","MHS_102","MHS_106"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getServiceErrorKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
	"typeName": "serviceErrorTextDTO",
    "totalNumberOfElements": 22,
    "from": 0,
    "to": 22,
    "valueList": [
        {
            "serviceErrorTextKey": "MHS_101",
            "value": "beschädigt"
        },
        {
            "serviceErrorTextKey": "MHS_102",
            "value": "Stauchung"
        },
        {
            "serviceErrorTextKey": "MHS_103",
            "value": "Kratzer"
        },
        {
            "serviceErrorTextKey": "MHS_104",
            "value": "Druckstellen"
        },
        {
            "serviceErrorTextKey": "MHS_106",
            "value": "Montagefehler"
        },
        {
            "serviceErrorTextKey": "MHS_107",
            "value": "Planungs-/Beratungsfehler"
        },
        {
            "serviceErrorTextKey": "MHS_108",
            "value": "Aufmaßfehler"
        },
        {
            "serviceErrorTextKey": "MHS_109",
            "value": "Bestellfehler"
        },
        {
            "serviceErrorTextKey": "MHS_110",
            "value": "AB nicht richtig geprüft"
        },
        {
            "serviceErrorTextKey": "MHS_111",
            "value": "Produktionsfehler"
        },
        {
            "serviceErrorTextKey": "MHS_112",
            "value": "Lieferverspätung"
        },
        {
            "serviceErrorTextKey": "MHS_113",
            "value": "Transportschaden"
        },
        {
            "serviceErrorTextKey": "MHS_116",
            "value": "Kulanz"
        },
        {
            "serviceErrorTextKey": "MHS_117",
            "value": "Fehlmenge"
        },
        {
            "serviceErrorTextKey": "MHS_118",
            "value": "Austausch"
        },
        {
            "serviceErrorTextKey": "MHS_119",
            "value": "Angeb.an Kd./auf Kd.Wunsch"
        },
        {
            "serviceErrorTextKey": "MHS_120",
            "value": "Kundendienst erforderlich"
        },
        {
            "serviceErrorTextKey": "MHS_121",
            "value": "Falschlieferung"
        },
        {
            "serviceErrorTextKey": "MHS_122",
            "value": "Nacharbeiten erforderlich"
        },
        {
            "serviceErrorTextKey": "MHS_123",
            "value": "Begutachtung erforderlich"
        },
        {
            "serviceErrorTextKey": "MHS_124",
            "value": "falsche Ausführung"
        },
        {
            "serviceErrorTextKey": "MHS_125",
            "value": "5 Jahresgarantie"
        }
    ]
}';
        return $this->applyFilter($json, $request, 'serviceErrorText');
    }

    /**
     * @OA\Get(
     *  path="/keys/serviceNote",
     *  tags={"Keys"},
     *  operationId="getServiceNoteKeys",
     *  summary="lieste alle Textbausteine für Kundendienst Notiz aus, abhängig von Mitarbeiter Gruppe",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="serviceNoteKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="int" ),
     *         example={1,2,3},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getServiceNoteKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
	"typeName": "serviceNoteDTO",
    "totalNumberOfElements": 10,
    "from": 0,
    "to": 10,
    "valueList": [
		 {
		   "serviceNoteKey": 1,
		   "serviceNoteGroup": "Monteur/Montage",
		   "value": "Kunde weigert sich Checkliste zu Unterschreiben"
		 },
		 {
		   "serviceNoteKey": 2,
		   "serviceNoteGroup": "Spedition/Lieferung",
		   "value": "falsches Grundrisse an Spedition versendet"
		 },
		 {
		   "serviceNoteKey": 3,
		   "serviceNoteGroup": "Monteur/Montage",
		   "value": "Spedition hatte die APl im Keller abgestellt,beim hochtragen hat der APL ein Kratzer gekriegt"
		 }
	]
}';
        return $this->applyFilter($json, $request, 'serviceNote');
    }

    /**
     * @OA\Get(
     *  path="/keys/employee",
     *  tags={"Keys"},
     *  operationId="getEmployeeKeys",
     *  summary="liest einen oder einzelne Mitarbeiter oder Mitarbeiter Gruppe aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="employeeKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_XYZ","MHS_ABC"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "emplyeeDTO",
    "totalNumberOfElements": 12,
    "from": 0,
    "to": 12,
    "valueList": [
        {
            "employeeKey": "MHS_XYZ",
            "employeeNumber": "XYZ",
            "employeeType": "3037",
            "kuerzel": "XYZ",
            "address": {
                "addressKey": "ECORO_32",
                "adressart": "HAUPTADRESSE",
                "salutationKey": "MHS_01",
                "titelKzFremdKey": null,
                "iso2A": "DE",
                "federalStateKey": null,
                "name2": "John",
                "name1": "Doe",
                "strasse": null,
                "plz": "99869",
                "ort": "Emleben",
                "ortsteil": null,
                "adressZusatz": null,
                "bemerkung": null,
                "namensZusatzFremdKey": null,
                "vorsatzwortFremdKey": null,
                "zustaendigkeitFremdKey": null,
                "etage": null,
                "fahrstuhl": false,
                "geburtsDatum": null
			},
            "contactList": [
                    {
                        "hauptkontakt": true,
                        "kontaktArt": "KOMART_MOBIL",
                        "kontakt": "0123/456789",
                        "bemerkung": "dienstlich"
                    },
                    {
                        "hauptkontakt": true,
                        "kontaktArt": "KOMART_TELEFON",
                        "kontakt": "0123/45679-23",
                        "bemerkung": "Durchwahl"
                    },
                    {
                        "hauptkontakt": true,
                        "kontaktArt": "KOMART_FAX",
                        "kontakt": "0123/45679-29",
                        "bemerkung": null
                    },
                    {
                        "hauptkontakt": true,
                        "kontaktArt": "KOMART_EMAIL",
                        "kontakt": "John.Doe@Marquardt-Kuechen.de",
                        "bemerkung": "dienstlich"
                    }
             ],
            "anmeldeberechtigt": true
        },
        {
            "employeeKey": "MHS_ABC",
            "employeeNumber": "ABC",
            "More": "..."
        }

    ]
}';
        return $this->applyFilter($json, $request, 'employee');
    }

    /**
     * @OA\Get(
     *  path="/keys/employeeType",
     *  tags={"Keys"},
     *  operationId="getEmployeeTypeKeys",
     *  summary="liest aller oder einzelne Mitarbeiter Tätigkeit aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="employeeTypeKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_3036","ECORO_3037"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeTypeKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "employeeTypeDTO",
    "totalNumberOfElements": 6,
    "from": 0,
    "to": 6,
    "valueList": [
		 {
		   "employeeTypeKey": "ECORO_2936",
		   "suchbegriff": 60,
		   "sorting": 60,
		   "value": "Fahrer",
		   "ecoroTextschluessel": 18
		 },
		 {
		   "employeeTypeKey": "ECORO_3036",
		   "suchbegriff": 10,
		   "sorting": 10,
		   "value": "Handelsvertreter",
		   "ecoroTextschluessel": 18
		 },
		 {
		   "employeeTypeKey": "ECORO_3037",
		   "suchbegriff": 20,
		   "sorting": 20,
		   "value": "Projektleiter",
		   "ecoroTextschluessel": 18
		 },
		 {
		   "employeeTypeKey": "ECORO_3236",
		   "suchbegriff": 40,
		   "sorting": 40,
		   "value": "Verwaltung",
		   "ecoroTextschluessel": 18
		 },
		 {
		   "employeeTypeKey": "ECORO_3237",
		   "suchbegriff": 70,
		   "sorting": 70,
		   "value": "Service-Monteur",
		   "ecoroTextschluessel": 18
		 },
		 {
		   "employeeTypeKey": "ECORO_3238",
		   "suchbegriff": 30,
		   "sorting": 30,
		   "value": "Empfang",
		   "ecoroTextschluessel": 18
		 }
    ]
}';
        return $this->applyFilter($json, $request, 'employeeType');
    }

    /**
     * @OA\Get(
     *  path="/keys/leadOrigin",
     *  tags={"Keys"},
     *  operationId="getLeadOriginKeys",
     *  summary="liest alle oder einzelne Herkunfts leadOriginList und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="leadOriginKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_2836","ECORO_642","ECORO_641"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getLeadOriginKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "warningList": [],
    "infoList": [],
    "totalNumberOfElements": 3,
    "from": 0,
    "to": 3,
    "valueList": [
		 {
		   "leadOriginKey": "ECORO_641",
		   "suchbegriff": 1,
		   "sorting": 1,
		   "value": "Online",
		   "ecoroTextschluessel": 8
		 },
		 {
		   "leadOriginKey": "ECORO_642",
		   "suchbegriff": 2,
		   "sorting": 2,
		   "value": "Lokal",
		   "ecoroTextschluessel": 8
		 },
		 {
		   "leadOriginKey": "ECORO_2836",
		   "suchbegriff": 3,
		   "sorting": 3,
		   "value": "Aroundhome",
		   "ecoroTextschluessel": 8
		 }
    ]
}';
        return $this->applyFilter($json, $request, 'leadOrigin');
    }

    /**
     * @OA\Get(
     *  path="/keys/outlet",
     *  tags={"Keys"},
     *  operationId="getOutletKeys",
     *  summary="liest alle oder teile der Filialedaten aus inkl. mitarbeiter",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="outletKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_05","MHS_06"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getOutletKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "outletDTO",
    "totalNumberOfElements": 61,
    "from": 0,
    "to": 5,
    "valueList": [
        {
            "outletKey": "MHS_05",
            "outletNumber": "05",
            "outletName": "Emleben",
            "outletType": "VERKAUFSFILIALE",
            "warehouseKey": "MHS_04",
            "iso2A": "DE",
            "adresse": {
                    "outletKey": "ECORO_534",
                    "adressart": "HAUPTADRESSE",
                    "salutationKey": "MHS_05",
                    "iso2A": "DE",
                    "federalStateKey": null,
                    "name2": "GmbH & Co. KG",
                    "name1": "Michael Marquardt",
                    "strasse": "Österfeldstraße 2-4",
                    "plz": "99869",
                    "ort": "Emleben",
                    "ortsteil": null,
                    "kpnCode": null,
                    "bemerkung": null,
                    "gln": "4260222480004"
				},
            "contactList": [
                        {
                            "hauptkontakt": true,
                            "kontaktArt": "KOMART_TELEFON",
                            "kontakt": "03621/776-100",
                            "bemerkung": null
                        },
                        {
                            "hauptkontakt": true,
                            "kontaktArt": "KOMART_FAX",
                            "kontakt": "03621776101",
                            "bemerkung": null
                        },
                        {
                            "hauptkontakt": false,
                            "kontaktArt": "KOMART_TELEFON",
                            "kontakt": "0202/251557008",
                            "bemerkung": null
                        },
                        {
                            "hauptkontakt": true,
                            "kontaktArt": "KOMART_EMAIL",
                            "kontakt": "Emleben@Marquardt-Kuechen.de",
                            "bemerkung": null,
                            "onlineAnmeldung": true
                        }
            ],
			"emplyeeList":[],
			"geometry": {
				"type": "Point",
				"coordinates": [
				  10.705116271973,
				  50.893325805664
				]
			},
            "opningsHoursSpecialList": [
                {
                    "datum": "01.05.2021",
                    "startZeit": "09:00",
                    "endZeit": "18:00",
                    "bezeichnung": "Arbeiternes Kampftag"
                }
            ],
            "openingHoursList": {
                "montagStart": "09:00",
                "montagEnde": "18:00",
                "montagSchautag": false,
                "dienstagStart": "08:00",
                "dienstagEnde": "18:00",
                "dienstagSchautag": false,
                "mittwochStart": "08:00",
                "mittwochEnde": "18:00",
                "mittwochSchautag": false,
                "donnerstagStart": "08:00",
                "donnerstagEnde": "18:00",
                "donnerstagSchautag": false,
                "freitagStart": "08:00",
                "freitagEnde": "18:00",
                "freitagSchautag": false,
                "samstagStart": "08:00",
                "samstagEnde": "18:00",
                "samstagSchautag": false,
                "sonntagStart": null,
                "sonntagEnde": null,
                "sonntagSchautag": false
            },
            "bankInformation": [
                {
                    "bank": "Kreissparkasse Gotha",
                    "bic": "HELADEF1GTH",
                    "iban": "DE03820520200750014725",
                    "iso2A": "DE",
                    "standard": true
                }
            ],
            "vatInformation":
                {
					"creditorIdentifier": "DE16ZZZ00001422089",
					"taxNumber": "156/159/13208",
					"businessYearStart": 1,
					"vatList": [
						{
						"iso2A": "DE",
						"vatIdNumber": "DE811301946"
						},
			            {
			          	  "iso2a": "BE",
			          	  "vatIdNumber": "BE3525253"
			            }
					]
                }
        },
        {
        "outletKey": "MHS_06",
        "more":""
        }
    ]
}';
        return $this->applyFilter($json, $request, 'outlet');
    }

    /**
     * @OA\Get(
     *  path="/keys/paymentTerm",
     *  tags={"Keys"},
     *  operationId="getPaymentTermKey",
     *  summary="liest alle oder einzelne zahlungs Bedingung aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="paymentTermKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_01","MHS_02","MHS_20"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPaymentTermKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "paymentTermDTO",
    "totalNumberOfElements": 11,
    "from": 0,
    "to": 11,
    "valueList": [
		 {
		   "paymentTermKey": "MHS_01",
		   "sorting": 2,
		   "value": "Barzahlung bei Lieferung",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_02",
		   "sorting": 3,
		   "value": "Überweisung vor Lieferung",
		   "DefaultPaymentTerm": true,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_03",
		   "sorting": 4,
		   "value": "BANKEINZUG",
		   "DefaultPaymentTerm": false,
		   "skontotage": 10,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_05",
		   "sorting": 6,
		   "value": "Zahlung bei Abholung",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_06",
		   "sorting": 7,
		   "value": "Komplettfinanzierung",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_07",
		   "sorting": 8,
		   "value": "Teilfinanzierung Rest bei Lief",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_08",
		   "sorting": 9,
		   "value": "Teilfinanzierung Rest per ÜW.",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_20",
		   "sorting": 11,
		   "value": "...keine Anzahlung",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_21",
		   "sorting": 12,
		   "value": "...Anzahlung ohne Skonto",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_22",
		   "sorting": 13,
		   "value": "...Anzahlung mit Skonto",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 2,
		   "sondernachlass": 0
		 },
		 {
		   "paymentTermKey": "MHS_23",
		   "sorting": 14,
		   "value": "...Komplettanzahlung",
		   "DefaultPaymentTerm": false,
		   "skontotage": 14,
		   "nettotage": 10,
		   "skontoprozent": 0,
		   "sondernachlass": 0
		 }
    ]
}';
        return $this->applyFilter($json, $request, 'paymentTerm');
    }

    /**
     * @OA\Get(
     *  path="/keys/probability",
     *  tags={"Keys"},
     *  operationId="getProbabilityKeys",
     *  summary="liest alle oder einzelne Wahrscheinlichkeits ErpFremdKey und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="probabilityKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_645","ECORO_646","ECORO_647"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getProbabilityKeys(Request $request)
    {
        $json = '{
   "status":"OK",
   "errorNumber":null,
   "errorMessage":null,
   "typeName":"probabilityDTO",
   "totalNumberOfElements":9,
   "from":0,
   "to":9,
   "valueList":[
      {
         "probabilityKey":"ECORO_645",
         "suchbegriff":"1",
         "sort":1,
         "value":"10%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_646",
         "suchbegriff":"2",
         "sort":2,
         "value":"20%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_647",
         "suchbegriff":"3",
         "sort":3,
         "value":"30%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_648",
         "suchbegriff":"4",
         "sort":4,
         "value":"40%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_649",
         "suchbegriff":"5",
         "sort":5,
         "value":"50%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_650",
         "suchbegriff":"6",
         "sort":6,
         "value":"60%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_651",
         "suchbegriff":"7",
         "sort":7,
         "value":"70%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_652",
         "suchbegriff":"8",
         "sort":8,
         "value":"80%",
         "ecoroTextschluessel":28
      },
      {
         "probabilityKey":"ECORO_653",
         "suchbegriff":"9",
         "sort":9,
         "value":"90%",
         "ecoroTextschluessel":28
      }
   ]
}';
        return $this->applyFilter($json, $request, 'probability');
    }

    /**
     * @OA\Get(
     *  path="/keys/salutation",
     *  tags={"Keys"},
     *  operationId="getSalutationKeys",
     *  summary="liest alle oder einzelne Anrede salutationList und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="salutationKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_01","MHS_02","MHS_03"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSalutationKeys(Request $request)
    {
        $json = '{
   "status":"OK",
   "errorNumber":null,
   "errorMessage":null,
   "typeName":"salutationDTO",
   "totalNumberOfElements":14,
   "from":0,
   "to":14,
   "valueList":[
      {
         "salutationKey":"MHS_01",
         "value":"Herr",
         "anredeKz":"8",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationKey":"MHS_02",
         "value":"Frau",
         "anredeKz":"9",
         "briefAnrede":"Sehr geehrte Frau"
      },
      {
         "salutationKey":"MHS_03",
         "value":"Herr und Frau",
         "anredeKz":"10",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationKey":"MHS_04",
         "value":"Handelsagentur",
         "anredeKz":"11",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationKey":"MHS_05",
         "value":"Firma",
         "anredeKz":"12",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationKey":"MHS_06",
         "value":"Herr Professor",
         "anredeKz":"13",
         "briefAnrede":"Sehr geehrter Herr Prof."
      },
      {
         "salutationKey":"MHS_07",
         "value":"Frau Professor",
         "anredeKz":"14",
         "briefAnrede":"Sehr geehrte Frau Prof."
      },
      {
         "salutationKey":"MHS_08",
         "value":"Herr Doktor",
         "anredeKz":"15",
         "briefAnrede":"Sehr geehrter Herr Dr."
      },
      {
         "salutationKey":"MHS_09",
         "value":"Handelsvertretung",
         "anredeKz":"16",
         "briefAnrede":"Sehr geehrte Damen und Herren,"
      },
      {
         "salutationKey":"MHS_10",
         "value":"Frau Doktor",
         "anredeKz":"17",
         "briefAnrede":"Sehr geehrte Frau Dr."
      },
      {
         "salutationKey":"MHS_11",
         "value":"Gemeinde",
         "anredeKz":"18",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationKey":"MHS_12",
         "value":"Montageservice",
         "anredeKz":"19",
         "briefAnrede":"Sehr geehrte Damen und Herren,"
      },
      {
         "salutationKey":"MHS_80",
         "value":"Herr und Herr",
         "anredeKz":"63",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationKey":"MHS_81",
         "value":"Frau und Frau",
         "anredeKz":"64",
         "briefAnrede":"Sehr geehrte Frau"
      }
   ]
}';
        return $this->applyFilter($json, $request, 'salutation');
    }

    /**
     * @OA\Get(
     *  path="/keys/salutationTitle",
     *  tags={"Keys"},
     *  operationId="getSalutationTitleKeys",
     *  summary="liest alle oder einzelne Title ErpFremdKey und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="salutationTitleKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"MHS_01","MHS_02","MHS_81"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSalutationTitleKeys(Request $request)
    {
        $json = '{
   "status":"OK",
   "errorNumber":null,
   "errorMessage":null,
   "typeName":"salutationDTO",
   "totalNumberOfElements":14,
   "from":0,
   "to":14,
   "valueList":[
      {
         "salutationTitleKey":"MHS_01",
         "value":"Herr",
         "anredeKz":"8",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationTitleKey":"MHS_02",
         "value":"Frau",
         "anredeKz":"9",
         "briefAnrede":"Sehr geehrte Frau"
      },
      {
         "salutationTitleKey":"MHS_03",
         "value":"Herr und Frau",
         "anredeKz":"10",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationTitleKey":"MHS_04",
         "value":"Handelsagentur",
         "anredeKz":"11",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationTitleKey":"MHS_05",
         "value":"Firma",
         "anredeKz":"12",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationTitleKey":"MHS_06",
         "value":"Herr Professor",
         "anredeKz":"13",
         "briefAnrede":"Sehr geehrter Herr Prof."
      },
      {
         "salutationTitleKey":"MHS_07",
         "value":"Frau Professor",
         "anredeKz":"14",
         "briefAnrede":"Sehr geehrte Frau Prof."
      },
      {
         "salutationTitleKey":"MHS_08",
         "value":"Herr Doktor",
         "anredeKz":"15",
         "briefAnrede":"Sehr geehrter Herr Dr."
      },
      {
         "salutationTitleKey":"MHS_09",
         "value":"Handelsvertretung",
         "anredeKz":"16",
         "briefAnrede":"Sehr geehrte Damen und Herren,"
      },
      {
         "salutationTitleKey":"MHS_10",
         "value":"Frau Doktor",
         "anredeKz":"17",
         "briefAnrede":"Sehr geehrte Frau Dr."
      },
      {
         "salutationTitleKey":"MHS_11",
         "value":"Gemeinde",
         "anredeKz":"18",
         "briefAnrede":"Sehr geehrte Damen und Herren"
      },
      {
         "salutationTitleKey":"MHS_12",
         "value":"Montageservice",
         "anredeKz":"19",
         "briefAnrede":"Sehr geehrte Damen und Herren,"
      },
      {
         "salutationTitleKey":"MHS_80",
         "value":"Herr und Herr",
         "anredeKz":"63",
         "briefAnrede":"Sehr geehrter Herr"
      },
      {
         "salutationTitleKey":"MHS_81",
         "value":"Frau und Frau",
         "anredeKz":"64",
         "briefAnrede":"Sehr geehrte Frau"
      }
   ]
}';
        return $this->applyFilter($json, $request, 'salutationTitle');
    }

    /**
     * @OA\Get(
     *  path="/keys/federalState",
     *  tags={"Keys"},
     *  operationId="getFederalStateKeys",
     *  summary="liest alle oder einzelne Bundesländer aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="federalStateKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_1","ECORO_16","ECORO_13"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getFederalStateKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
	"dataType": "federalStateDTO",
    "totalNumberOfElements": 6,
    "from": 0,
    "to": 6,
    "valueList": [
		 {
		   "federalStateKey": "ECORO_1",
		   "value": "Hessen",
		   "federalStateShortKey": "HE",
		   "iso2A": "DE",
		   "IntraStatKey": 6
		 },
		 {
		   "federalStateKey": "ECORO_2",
		   "value": "Rheinland-Pfalz",
		   "federalStateShortKey": "RP",
		   "iso2A": "DE",
		   "IntraStatKey": 7
		 },
		 {
		   "federalStateKey": "ECORO_3",
		   "value": "Baden-Württemberg",
		   "federalStateShortKey": "BW",
		   "iso2A": "DE",
		   "IntraStatKey": 8
		 },
		 {
		   "federalStateKey": "ECORO_4",
		   "value": "Saarland",
		   "federalStateShortKey": "SL",
		   "iso2A": "DE",
		   "IntraStatKey": 10
		 },
		 {
		   "federalStateKey": "ECORO_5",
		   "value": "Nordrhein-Westfalen",
		   "federalStateShortKey": "NW",
		   "iso2A": "DE",
		   "IntraStatKey": 5
		 },
		 {
		   "federalStateKey": "ECORO_6",
		   "value": "Bayern",
		   "federalStateShortKey": "BY",
		   "iso2A": "DE",
		   "IntraStatKey": 9
		 },
		 {
		   "federalStateKey": "ECORO_7",
		   "value": "Berlin",
		   "federalStateShortKey": "B",
		   "iso2A": "DE",
		   "IntraStatKey": 11
		 },
		 {
		   "federalStateKey": "ECORO_8",
		   "value": "Niedersachsen",
		   "federalStateShortKey": "NI",
		   "iso2A": "DE",
		   "IntraStatKey": 3
		 },
		 {
		   "federalStateKey": "ECORO_9",
		   "value": "Sachsen-Anhalt",
		   "federalStateShortKey": "ST",
		   "iso2A": "DE",
		   "IntraStatKey": 15
		 },
		 {
		   "federalStateKey": "ECORO_10",
		   "value": "Hamburg",
		   "federalStateShortKey": "HH",
		   "iso2A": "DE",
		   "IntraStatKey": 2
		 },
		 {
		   "federalStateKey": "ECORO_11",
		   "value": "Sachsen",
		   "federalStateShortKey": "SN",
		   "iso2A": "DE",
		   "IntraStatKey": 14
		 },
		 {
		   "federalStateKey": "ECORO_12",
		   "value": "Bremen",
		   "federalStateShortKey": "HB",
		   "iso2A": "DE",
		   "IntraStatKey": 4
		 },
		 {
		   "federalStateKey": "ECORO_13",
		   "value": "Thüringen",
		   "federalStateShortKey": "TH",
		   "iso2A": "DE",
		   "IntraStatKey": 16
		 },
		 {
		   "federalStateKey": "ECORO_14",
		   "value": "Mecklenburg-Vorpommern",
		   "federalStateShortKey": "MV",
		   "iso2A": "DE",
		   "IntraStatKey": 13
		 },
		 {
		   "federalStateKey": "ECORO_15",
		   "value": "Brandenburg",
		   "federalStateShortKey": "BB",
		   "iso2A": "DE",
		   "IntraStatKey": 12
		 },
		 {
		   "federalStateKey": "ECORO_16",
		   "value": "Schleswig-Holstein",
		   "federalStateShortKey": "SH",
		   "iso2A": "DE",
		   "IntraStatKey": 1
		 }
		]
}';
        return $this->applyFilter($json, $request, 'federalState');
    }

    /**
     * @OA\Get(
     *  path="/keys/leadStatus",
     *  tags={"Keys"},
     *  operationId="getLeadStatusKeys",
     *  summary="liest alle oder einzelne Chance Status leadStatusList und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="leadStatusKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_636","ECORO_637","ECORO_2841"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getLeadStatusKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "leadStatusDTO",
    "totalNumberOfElements": 6,
    "from": 0,
    "to": 6,
    "valueList": [
        {
            "leadStatusKey": "ECORO_636",
            "suchbegriff": "1",
            "sorting": 1,
            "value": "Neu",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_637",
            "suchbegriff": "2",
            "sorting": 2,
            "value": "Nachfassen",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_638",
            "suchbegriff": "3",
            "sorting": 3,
            "value": "Überfällig",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_639",
            "suchbegriff": "4",
            "sorting": 4,
            "value": "Angebot",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_640",
            "suchbegriff": "5",
            "sorting": 5,
            "value": "Kaufvertrag",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_2636",
            "suchbegriff": "6",
            "sorting": 6,
            "fixtext": false,
            "value": "Kataloganfrage",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_2637",
            "suchbegriff": "7",
            "sorting": 7,
            "fixtext": false,
            "value": "Katalog verschickt",
            "ecoroTextschluessel": 6
        },
        {
            "leadStatusKey": "ECORO_2841",
            "suchbegriff": "8",
            "sorting": 8,
            "fixtext": false,
            "value": "erledigt",
            "ecoroTextschluessel": 6
        }
    ]
}';
        return $this->applyFilter($json, $request, 'leadStatus');
    }

    /**
     * @OA\Get(
     *  path="/keys/intentToPurchase",
     *  tags={"Keys"},
     *  operationId="getIntentToPurchaseKeys",
     *  summary="liest alle oder einzelne Kaufabschichts ErpFremdKey und bez. aus",
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(name="intentToPurchaseKeyList[]",
     *    in="query",
     *    description="List of keys to search, show all if null",
     *
     *    @OA\Schema(
     *         type="array",
     *         collectionFormat="multi",
     *         @OA\Items( type="string" ),
     *         example={"ECORO_654","ECORO_655","ECORO_656"},
     *    ),
     *  ),
     *  @OA\Response(response="200",
     *    description="Validation Response",
     *      @OA\JsonContent()
     *  )
     * )
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIntentToPurchaseKeys(Request $request)
    {
        $json = '{
    "status": "OK",
    "errorNumber": null,
    "errorMessage": null,
    "typeName": "intentToPurchaseDTO",
    "totalNumberOfElements": 6,
    "from": 0,
    "to": 6,
    "valueList": [
				{
					"intentToPurchaseKey": "ECORO_654",
					"suchbegriff": 0,
					"sorting": 0,
					"value": "0 Tage",
					"ecoroTextschluessel": 33
				},
				{
					"intentToPurchaseKey": "ECORO_655",
					"suchbegriff": 1,
					"sorting": 1,
					"value": "1 Tag",
					"ecoroTextschluessel": 33
				},
				{
					"intentToPurchaseKey": "ECORO_656",
					"suchbegriff": 2,
					"sorting": 2,
					"value": "1 Woche",
					"ecoroTextschluessel": 33
				}
    ]
}';
        return $this->applyFilter($json, $request, 'intentToPurchase');
    }


}
