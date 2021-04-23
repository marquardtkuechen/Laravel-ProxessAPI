<?php
/** @OA\Info(
 *     title="MMA REST API",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="steven.madsen@marquardt-kuechen.de"
 *     ),
 *     description="MarquardtMetaAPI<br>API Rate Limits: 60 Requests/Minute<br>Document endpoint requires Office365 authentification<br><br><strong>Caution!</strong> Some endpoints are still under heavy development. They may change format and fields or deliver static test data.",
 *     )
 *   @OA\Server(
 *     description="MMA - MarquardtMetaAPI Live",
 *     url="https://api.marquardt-kuechen.de/mma/v1/"
 * )
 */

/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="Authorization",
 *      type="http",
 *      scheme="bearer",
 *     description="MMA main authentification"
 *
 * ),
 *  * @OA\SecurityScheme(
 *   securityScheme="token",
 *   type="apiKey",
 *   name="oAuth2accessToken",
 *   in="query",
 *     description="Only for document endpoint authentification"
 * )
 */
