<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function show()
    {
        $city = request('city', env('OPENWEATHER_CITY', 'Riga'));
        $key = env('OPENWEATHER_KEY');

        $fallback = fn(string $reason) => response()->json([
            'city' => $city,
            'temp' => null,
            'desc' => $reason,
        ], 200);

        if (!$key) {
            return $fallback('API key not configured (fallback)');
        }

        try {
            $res = Http::timeout(5)->get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $key,
                'units' => 'metric',
            ]);

            if (!$res->ok()) {
                return $fallback('Weather API unavailable (fallback)');
            }

            $j = $res->json();

            return response()->json([
                'city' => $j['name'] ?? $city,
                'temp' => $j['main']['temp'] ?? null,
                'desc' => $j['weather'][0]['description'] ?? '',
            ], 200);
        } catch (\Throwable $e) {
            return $fallback('Connection error (fallback)');
        }
    }
}
