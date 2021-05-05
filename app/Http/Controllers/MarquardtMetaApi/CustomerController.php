<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarquardtMetaApi\Kunden\getKundenRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Customer",
     *     description="Customer",
     * )
     * /
     *
     */
     /**
     * @OA\POST(
     *  path="/customer",
     *  tags={"Customer"},
     *  operationId="createCustomer",
     *  summary="",
     *  security={{"bearerAuth": {}}},

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

    public function createCustomer(Request $request){

        return "";
    }

}
