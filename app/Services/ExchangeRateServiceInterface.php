<?php
// app/Services/ExchangeRateServiceInterface.php
namespace App\Services;

interface ExchangeRateServiceInterface
{
    public function getExchangeRate(): float;
}