<?php

namespace App\Http\Resources;


class ChanceGetKaufabsichtResource extends BaseChanceResource
{

    public function __construct($jsonObject, $valueClass = ChanceGetKaufabsichtValue::class)
    {
        parent::__construct($jsonObject, $valueClass);
    }
}

class ChanceGetKaufabsichtValue extends BaseChanceValue
{

    public function __construct($jsonObject)
    {
        parent::__construct($jsonObject);
        $this->value = $jsonObject['chancenKaufabsicht'];
    }

}


