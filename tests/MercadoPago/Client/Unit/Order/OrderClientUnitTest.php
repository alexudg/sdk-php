<?php

namespace MercadoPago\Tests\Client\Unit\Order;

use MercadoPago\Client\Order\OrderClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\MPDefaultHttpClient;
use MercadoPago\Tests\Client\Unit\Base\BaseClient;

/**
 * Order Client unit tests.
 */
final class OrderClientUnitTest extends BaseClient
{
    public function testCreateSuccess(): void
    {
        $filepath = '../../../../Resources/Mocks/Response/Order/order.json';
        $mock_http_request = $this->mockHttpRequest($filepath, 200);

        $http_client = new MPDefaultHttpClient($mock_http_request);
        MercadoPagoConfig::setHttpClient($http_client);

        $client = new OrderClient();
        $order = $client->create($this->createRequest());
        $this->assertSame(200, $order->getResponse()->getStatusCode());
        $this->assertSame("01HRYFWNYRE1MR1E60MW3X0T2P", $order->id);
        $this->assertSame("online", $order->type);
        $this->assertSame("1000.00", $order->total_amount);
        $this->assertSame("ext_ref_1234", $order->external_reference);
        $this->assertSame("01HRYFXQ53Q3JPEC48MYWMR0TE", $order->transactions->payments[0]->id);
        $this->assertSame("processed", $order->transactions->payments[0]->status);
        $this->assertSame("1000.00", $order->transactions->payments[0]->amount);
        $this->assertSame("master", $order->transactions->payments[0]->payment_method->id);
        $this->assertSame("credit_card", $order->transactions->payments[0]->payment_method->type);
        $this->assertSame("test_user@testuser.com", $order->payer->email);
    }

    private function createRequest(): array
    {
        $request = [
            "type" => "online",
            "total_amount" => "1000.00",
            "external_reference" => "ext_ref_1234",
            "transactions" => [
                "payments" => [
                    [
                        "amount" => "1000.00",
                        "payment_method" => [
                            "id" => "master",
                            "token" => "card_token"
                        ],
                    ],
                ]
            ],
            "payer" => [
                "email" => "test_user@testuser.com",
            ]
        ];
        return $request;
    }
}
