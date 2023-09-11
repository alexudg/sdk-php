<?php

namespace MercadoPago\Client\IdentificationType;

use MercadoPago\Client\MercadoPagoClient;
use MercadoPago\Core\MPRequestOptions;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\HttpMethod;
use MercadoPago\Resources\IdentificationTypeResult;

/** Client responsible for performing identification type actions. */
final class IdentificationTypeClient extends MercadoPagoClient
{
    private static $URL = "/v1/identification_types";

    /** Default constructor. Uses the default http client used by the SDK. */
    public function __construct()
    {
        parent::__construct(MercadoPagoConfig::getHttpClient());
    }

    /**
     * Method responsible for list identification types.
     * @param \MercadoPago\Core\MPRequestOptions request options to be sent.
     * @return \MercadoPago\Resources\IdentificationTypeResult identification type found.
     * @throws \MercadoPago\Exceptions\MPApiException if the request fails.
     * @throws \Exception if the request fails.
     */
    public function list(?MPRequestOptions $request_options = null): IdentificationTypeResult
    {
        $response = parent::send(self::$URL, HttpMethod::GET, null, null, $request_options);
        $result = new IdentificationTypeResult();
        $result->data = $response->getContent();
        $result->setResponse($response);
        return $result;
    }
}
