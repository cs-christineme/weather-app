<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlacesController extends Controller
{
    public function getPlaces($city)
    {
        $apiKey = 'c199c69b187e4fe1bf1d2c793fad4bcb';

        // Get general location information
        $locationResponse = Http::get("https://api.geoapify.com/v1/geocode/search?text={$city}&apiKey={$apiKey}");
        $locationData = $locationResponse->json();

        // Check if features key exists in the response
        if (!isset($locationData['features']) || empty($locationData['features'])) {
            return response()->json(['error' => 'No location information available.']);
        }

        // Extract latitude and longitude from the first result
        $latitude = $locationData['features'][0]['geometry']['coordinates'][1];
        $longitude = $locationData['features'][0]['geometry']['coordinates'][0];

        // Get information about attractions and landmarks
        $attractionsResponse = Http::get("https://api.geoapify.com/v2/places?categories=tourism.attraction&lat={$latitude}&lon={$longitude}&limit=5&apiKey={$apiKey}");
        $attractionsData = $this->extractAddressLine1($attractionsResponse->json());

        // Get information about transportation
        $transportationResponse = Http::get("https://api.geoapify.com/v2/places?categories=building.transportation&lat={$latitude}&lon={$longitude}&limit=5&apiKey={$apiKey}");
        $transportationData = $this->extractAddressLine1($transportationResponse->json());

        // Get information about accommodation
        $accommodationResponse = Http::get("https://api.geoapify.com/v2/places?categories=accommodation&lat={$latitude}&lon={$longitude}&limit=5&apiKey={$apiKey}");
        $accommodationData = $this->extractAddressLine1($accommodationResponse->json());

        return response()->json([
            'location' => [
                'country' => $locationData['features'][0]['properties']['country'],
                'formatted_address' => $locationData['features'][0]['properties']['formatted'],
            ],
            'attractions' => $attractionsData,
            'transportation' => $transportationData,
            'accommodation' => $accommodationData,
        ]);
    }

    private function extractAddressLine1($data)
    {
        return array_map(function ($item) {
            return $item['properties']['address_line1'] ?? '';
        }, $data['features'] ?? []);
    }
}
