<?php

namespace App\Http\Controllers\MarquardtMetaApi;

use App\Facades\EcoroWawiFacade as EcoroWawi;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarquardtMetaApi\Kunden\getKundenRequest;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    /**
     * @OA\Tag(
     *     name="CustomerService",
     *     description="CustomerService",
     * )
     * /
     *
     */
     /**
     * @OA\POST(
     *  path="/customerService",
     *  tags={"CustomerService"},
     *  operationId="createCustomerService",
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

    public function createCustomerService(Request $request){

        return "";
    }


    /**
     * @OA\Get (
     *  path="/customerService",
     *  tags={"CustomerService"},
     *  operationId="createCustomerService",
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
    /**
     * @OA\Patch (
     *  path="/customerService",
     *  tags={"CustomerService"},
     *  operationId="createCustomerService",
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
    /**
     * @OA\Delete  (
     *  path="/customerService",
     *  tags={"CustomerService"},
     *  operationId="createCustomerService",
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
}
