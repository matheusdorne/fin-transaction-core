<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class AuthorizationService
{
    // Mirror URL to simulate anti-fraud system
    private const URL = 'https://util.devi.tools/api/v2/authorize';

    public function authorize(): bool
    {
        $response = Http::timeout(2)->get(self::URL);

        if ($response->failed()) {
            throw new Exception('Authorization service unavailable');
        }

        $data = $response->json();

        if (! isset($data['data']['authorization']) || $data['data']['authorization'] !== true) {
            return false;
        }

        return true;
    }
}
