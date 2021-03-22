<?php

namespace App\Http\Resources;

class ChancenGetWahrscheinlichkeit
{
    private $status;
    private $errorMessage;
    private $typeName;
    private $totalNumberOfElements;
    private $from;
    private $to;
    private $valueList;

    public function __construct($jsonObject) {
        $this->status = $jsonObject['status'];
        $this->errorMessage = $jsonObject['errorMessage'];
        //$this->typeName = "Woher??";//$jsonObject->; // Woher??
        $this->totalNumberOfElements = $jsonObject['totalNumberOfElements'];
        $this->from = $jsonObject['from'];
        $this->to = $jsonObject['to'];
        $this->valueList = array();

        foreach ($jsonObject['value'] as $key => $valueItem) {
            $chancenGetWahrscheinlichkeitValue = new ChancenGetWahrscheinlichkeitValue($valueItem);
            array_push($this->valueList, $chancenGetWahrscheinlichkeitValue->toArray());
            /// TODO Soll das so bleiben?
            $this->typeName = $valueItem['typeName'];
        }
    }

    /**
     * Transform object into an array.
     *
     * @return array
     */
    public function toArray()
    {
        //return get_object_vars($this);
        return [
            "status" => $this->status,
            "errorMessage" => $this->errorMessage,
            "typeName" => $this->typeName,
            "totalNumberOfElements" => $this->totalNumberOfElements,
            "from" => $this->from,
            "to" => $this->to,
            "valueList" => $this->valueList,
        ];
    }
}

class ChancenGetWahrscheinlichkeitValue {
    private $erpFremdKey;
    private $sort;
    private $value;

    public function __construct($jsonObject) {
        $this->erpFremdKey = $jsonObject['erpFremdKey'];
        $this->sort = $jsonObject['sortierung'];
        $this->value = $jsonObject['chancenWahrscheinlichkeit'];
    }
    
    public function toArray()
    {
        //return get_object_vars($this);
        return [
            "erpFremdKey" => $this->erpFremdKey,
            "sort" => $this->sort,
            "value" => $this->value,
        ];
    }
}