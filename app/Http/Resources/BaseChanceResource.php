<?php

namespace App\Http\Resources;

abstract class BaseChanceResource
{
    protected $status;
    protected $errorMessage;
    protected $typeName;
    protected $totalNumberOfElements;
    protected $from;
    protected $to;
    protected $valueList;

    public function __construct($jsonObject, $valueClass)
    {
        if (!(is_subclass_of($valueClass, BaseChanceValue::class))) return false;
        $this->status = $jsonObject['status'];
        $this->errorMessage = $jsonObject['errorMessage'];
        //$this->typeName = "Woher??";//$jsonObject->; // Woher??
        $this->totalNumberOfElements = $jsonObject['totalNumberOfElements'];
        $this->from = $jsonObject['from'];
        $this->to = $jsonObject['to'];
        $this->valueList = array();

        foreach ($jsonObject['value'] as $key => $valueItem) {
            $chanceGetAufmerksamkeitValue = new $valueClass($valueItem);

            array_push($this->valueList, $chanceGetAufmerksamkeitValue->toArray());
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
            "status"                => $this->status,
            "errorMessage"          => $this->errorMessage,
            "typeName"              => $this->typeName,
            "totalNumberOfElements" => $this->totalNumberOfElements,
            "from"                  => $this->from,
            "to"                    => $this->to,
            "valueList"             => $this->valueList,
        ];
    }
}

abstract class BaseChanceValue
{
    protected $erpFremdKey;
    protected $sort;
    protected $value;

    public function __construct($jsonObject)
    {
        $this->erpFremdKey = $jsonObject['erpFremdKey'];
        $this->sort = $jsonObject['sortierung'];
        // $this->value = $jsonObject['chancenAufmerksamkeit'];
    }

    public function toArray()
    {
        //return get_object_vars($this);
        return [
            "erpFremdKey" => $this->erpFremdKey,
            "sort"        => $this->sort,
            "value"       => $this->value,
        ];
    }
}
