<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $client = new Client();
        $country = $request->input('country');
        $apiKey = '230b2cf0d7784712a59204342241808'; // Replace with your actual WeatherAPI key

        // Build the API request URL
        // Using forecast endpoint instead of current weather
    $response = $client->get("http://api.weatherapi.com/v1/forecast.json?key={$apiKey}&q={$country}&days=3&aqi=no&alerts=no");
    $weatherData = json_decode($response->getBody(), true);

        // Pass the weather data to the view
        return view('welcome', ['weather' => $weatherData]);
    }

}
