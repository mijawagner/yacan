<?php

namespace Tests\Feature;

use Tests\TestCase;


class ExchangeRateApiTest extends TestCase
{

    public function testValidTokenReturnsExchangeRate()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer 567',
        ])->get('/api/exchange');

        $response->assertStatus(200);
        $response->assertJsonStructure(['exchange_rate']);
    }

    public function testInvalidTokenReturnsUnauthorized()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 567)',
        ])->get('/api/exchange');

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid token format']);
    }

}