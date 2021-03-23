<?php

namespace App\Http\Resources;

class ChanceGetHerkunftResource extends BaseChanceResource
{

    public function __construct($jsonObject,$valueClass = ChanceGetHerkunfttValue::class)
    {
        parent::__construct($jsonObject, $valueClass);
    }

}

class ChanceGetHerkunfttValue extends BaseChanceValue {

    public function __construct($jsonObject) {
        parent::__construct($jsonObject);
        $this->value = $jsonObject['chancenHerkunft'];
    }
}
