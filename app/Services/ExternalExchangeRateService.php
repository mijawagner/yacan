<?php
// app/Services/ExternalExchangeRateService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalExchangeRateService implements ExchangeRateServiceInterface
{
    private static $instance = null;
    private $apiKey;
    private $apiUrl;

    private function __construct()
    {
        $this->apiKey = getenv('SERVICES_EXCHANGE_API_KEY');
        $this->apiUrl = getenv('SERVICES_EXCHANGE_API_URL');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getExchangeRate(): float
    {
        // Call External Api
        $response = Http::get($this->apiUrl, [
            'access_key' => $this->apiKey,
            'symbols' => 'EUR,USD',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['rates']['EUR'] / $data['rates']['USD'];
        }

        throw new \Exception('Error al obtener el tipo de cambio.');

    }
}