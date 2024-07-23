<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Tests\TestCase;

class StressTest extends TestCase
{
    /**
     * A stress test example with concurrent requests.
     *
     * @return void
     */
    public function testConcurrentRequests()
    {
        $baseUrl = 'http://134.122.77.249:8000/';
        $client = new Client(['base_uri' => $baseUrl]);
        $promises = [];

        // Create 500 requests
        for ($i = 0; $i < 500; $i++) {
            $promises[] = $client->getAsync('/');
        }

        // Wait for all requests to complete
        $responses = Utils::settle($promises)->wait();

        // Check if all requests are successful
        foreach ($responses as $response) {
            $this->assertEquals('fulfilled', $response['state']);
            $this->assertEquals(200, $response['value']->getStatusCode());
        }
    }
}
