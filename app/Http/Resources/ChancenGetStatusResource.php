<?php

namespace App\Http\Resources;


class ChancenGetStatusResource extends BaseChanceResource
{

    public function __construct($jsonObject,$valueClass = ChancenGetStatusValue::class)
    {
        parent::__construct($jsonObject, $valueClass);
    }

}

class ChancenGetStatusValue extends BaseChanceValue
{

    public function __construct($jsonObject)
    {
        parent::__construct($jsonObject);
        $this->value = $jsonObject['chancenStatus'];
    }

}
