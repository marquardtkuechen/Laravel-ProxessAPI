<?php

namespace App\Http\Resources;

class ChancenGetWahrscheinlichkeitResource extends BaseChanceResource
{

    public function __construct($jsonObject, $valueClass = ChancenGetWahrscheinlichkeitValue::class)
    {
        parent::__construct($jsonObject, $valueClass);
    }

}

class ChancenGetWahrscheinlichkeitValue extends BaseChanceValue
{

    public function __construct($jsonObject)
    {
        parent::__construct($jsonObject);
        $this->value = $jsonObject['chancenWahrscheinlichkeit'];
    }

}
