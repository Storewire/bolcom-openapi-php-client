<?php

use PHPUnit\Framework\TestCase;
use BolCom\Client;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(getenv('BOLCOM_OPEN_API_KEY'), true);
    }

    /** @test */
    public function appKey()
    {
        $this->assertNotEmpty(
            getenv('BOLCOM_OPEN_API_KEY'),
          "No legacy API key passed in `BOLCOM_OPEN_API_KEY` environment variable"
        );
    }

    /** @test */
    public function getPingResponse()
    {
        $response = $this->client->getPingResponse();

        $this->assertObjectHasAttribute('Message', $response);
        $this->assertEquals('Hello World!', $response->Message);
    }

    /** @test */
    public function getProduct()
    {
        $response = $this->client->getProduct('9200000015051259');

        $this->assertObjectHasAttribute('products', $response);
        $this->assertIsArray($response->products);
    }
}
