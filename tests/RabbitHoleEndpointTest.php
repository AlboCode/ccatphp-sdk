<?php

namespace Albocode\CcatphpSdk\Tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;

class RabbitHoleEndpointTest extends BaseTest
{
    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetAllowedMimeTypesSuccess(): void
    {
        $expected = ['allowed' => ['application/pdf', 'text/plain', 'text/markdown', 'text/html']];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->rabbitHole();
        $result = $endpoint->getAllowedMimeTypes();

        self::assertEquals($expected['allowed'], $result->allowed);
    }

}