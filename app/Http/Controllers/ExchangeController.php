<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExternalExchangeRateService;

class ExchangeController extends Controller
{
    public function getExchangeRate(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            $isvalid = $this->validateToken($token);
            if ( !$isvalid) {
                return response()->json(['error' => 'Invalid token format'], 400);
            }
        } else {
            return response()->json(['error' => 'Token empty'], 400);
        }

        $exchangeService = ExternalExchangeRateService::getInstance();
        try {
            $exchangeRate = $exchangeService->getExchangeRate();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['exchange_rate' => $exchangeRate, 'token' => $token]);
    }

  
    private function validateToken($string)
    {
        $stack = [];
        $bracketPairs = [
            '{' => '}',
            '[' => ']',
            '(' => ')'
        ];

        foreach (str_split($string) as $char) {
            if (isset($bracketPairs[$char])) {
                // If it's an opening bracket, push it onto the stack
                $stack[] = $char;
            } elseif (in_array($char, $bracketPairs)) {
                // If it's a closing bracket, check for matching opening bracket
                if (empty($stack) || $bracketPairs[array_pop($stack)] !== $char) {
                    return false;
                }
            }
        }

        // Valid if the stack is empty (all brackets closed)
        return empty($stack);
    }
}