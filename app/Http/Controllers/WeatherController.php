<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather($city)
    {
        $apiKey = 'e73df5c2d48c0deec5fe0e272e17128f';
        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}");
        $weatherData = $response->json();

        $formattedData = $this->formatWeatherData($weatherData);

        return response()->json($formattedData);
    }

    private function formatWeatherData($weatherData)
    {
        $formattedData = [];

        foreach ($weatherData['list'] as $item) {
            $day = date('d', $item['dt']);

            // Create a new array for the day if it doesn't exist
            if (!isset($formattedData[$day])) {
                $formattedData[$day] = [];
            }

            // Map weather descriptions to icons
            $weatherIcons = [
                'Rain' => 'https://img.icons8.com/color-glass/42/000000/rain.png',
                'Clouds' => 'https://img.icons8.com/color-glass/42/000000/cloud.png',
                'Clear' => 'https://img.icons8.com/color-glass/42/000000/sun.png',
                'Partly cloudy' => 'https://img.icons8.com/color-glass/42/000000/partly-cloudy-day.png',
                'Wind' => 'https://img.icons8.com/color-glass/42/000000/wind.png',
                'Snow' => 'https://img.icons8.com/color-glass/42/000000/snow.png',
                // Add more mappings as needed
            ];

            $weatherDescription = $item['weather'][0]['main'];
            $icon = $weatherIcons[$weatherDescription] ?? '';

            // You can customize the weather status as needed
            $weatherStatus = $this->getWeatherStatus($item['weather'][0]['id']);

            $formattedData[$day][] = [
                'date' => date('M d, Y', $item['dt']),
                'temperature' => $item['main']['temp'],
                'description' => $item['weather'][0]['description'],
                'icon' => $icon,
                'weather' => $weatherStatus,
            ];
        }

        return $formattedData;
    }

    private function getWeatherStatus($weatherId)
    {
        // Customize the weather status based on weather ID
        if ($weatherId >= 200 && $weatherId < 300) {
            return 'Thunderstorm';
        } elseif ($weatherId >= 300 && $weatherId < 500) {
            return 'Drizzle';
        } elseif ($weatherId >= 500 && $weatherId < 600) {
            return 'Rain';
        } elseif ($weatherId >= 600 && $weatherId < 700) {
            return 'Snow';
        } elseif ($weatherId >= 700 && $weatherId < 800) {
            return 'Atmosphere';
        } elseif ($weatherId == 800) {
            return 'Clear';
        } elseif ($weatherId > 800) {
            return 'Clouds';
        } else {
            return 'Unknown';
        }
    }
}
