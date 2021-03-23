<?php

namespace App\Http\Resources;

class ChanceGetAufmerksamkeitResource extends BaseChanceResource
{

    public function __construct($jsonObject, $valueClass = ChanceGetAufmerksamkeitValue::class)
    {
        parent::__construct($jsonObject, $valueClass);
    }
}

class ChanceGetAufmerksamkeitValue extends BaseChanceValue
{

    public function __construct($jsonObject)
    {
        parent::__construct($jsonObject);
        $this->value = $jsonObject['chancenAufmerksamkeit'];
    }

}
