<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weather APP</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite('resources/css/app.css')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            /* Particle animation */
            .particles {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
                z-index: 1;
            }

            .particle {
                position: absolute;
                background: rgba(255, 255, 255, 0.8);
                border-radius: 50%;
                opacity: 0.8;
                animation: float 10s linear infinite;
            }

            @keyframes float {
                0% {
                    transform: translateY(0) scale(1);
                    opacity: 0.8;
                }
                100% {
                    transform: translateY(-2000px) scale(0.5);
                    opacity: 0;
                }
            }

            .bg-animated {
                background: linear-gradient(135deg, #1e3a8a, #3b82f6, #9333ea);
                background-size: 400% 400%;
                animation: bgShift 15s ease infinite;
            }

            @keyframes bgShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .fade-in {
                animation: fadeIn 2s ease-in-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            .floating {
                animation: floating 3s ease-in-out infinite;
            }

            @keyframes floating {
                from { transform: translateY(0); }
                50% { transform: translateY(-10px); }
                to { transform: translateY(0); }
            }
        </style>
    </head>
    <body class="bg-animated min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="particles">
            @for ($i = 0; $i < 100; $i++)
                <div class="particle" style="
                    width: {{ rand(5, 10) }}px;
                    height: {{ rand(5, 10) }}px;
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-duration: {{ rand(5, 15) }}s;
                    animation-delay: {{ rand(-20, 0) }}s;">
                </div>
            @endfor
        </div>
        <div class="max-w-lg w-full bg-white bg-opacity-70 backdrop-blur-lg shadow-lg rounded-3xl p-10 fade-in relative z-10">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Discover the Weather</h1>
            <div class="text-center mb-10">
                <p class="text-lg text-gray-700">Enter your country below to explore the current weather conditions.</p>
            </div>
            <form method="POST" action="{{ route('weather.fetch') }}" class="space-y-6">
                @csrf
                <div class="relative">
                    <input type="text" id="country" name="country" placeholder="Enter Country"
                           class="w-full px-6 py-4 text-lg border rounded-full focus:outline-none focus:ring-4 focus:ring-blue-500 transition ease-in-out duration-300 shadow-md">
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0a7.5 7.5 0 1110.57-10.57 7.5 7.5 0 01-10.57 10.57z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-500 to-indigo-500 text-white py-4 rounded-full font-semibold text-xl transform hover:scale-105 transition ease-in-out duration-300 shadow-lg">
                        Show Weather
                    </button>
                </div>
            </form>

            @if(isset($weather))
            <div class="mt-10 text-center fade-in">
                <h2 class="text-3xl font-bold text-gray-900">{{ $weather['location']['name'] }}, {{ $weather['location']['country'] }}</h2>
                <div class="text-6xl font-bold text-blue-600 mt-4">{{ $weather['current']['temp_c'] }}°C</div>
                <div class="text-lg font-medium text-gray-700 mt-2">{{ $weather['current']['condition']['text'] }}</div>
                <img src="https:{{ $weather['current']['condition']['icon'] }}" alt="Weather Icon" class="mx-auto mt-4">
                <p class="text-sm text-gray-600 mt-2">Stay prepared, stay safe.</p>

                <h3 class="text-2xl font-semibold text-gray-900 mt-8">Forecast</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($weather['forecast']['forecastday'] as $day)
                        <div class="bg-white bg-opacity-50 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-bold">{{ \Carbon\Carbon::parse($day['date'])->format('l, F j') }}</h4>
                            <img src="https:{{ $day['day']['condition']['icon'] }}" alt="Forecast Icon" class="mx-auto mt-2">
                            <div class="text-md text-gray-700 mt-2">{{ $day['day']['condition']['text'] }}</div>
                            <div class="text-lg text-gray-900 mt-1">Max: {{ $day['day']['maxtemp_c'] }}°C</div>
                            <div class="text-lg text-gray-900">Min: {{ $day['day']['mintemp_c'] }}°C</div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </body>
</html>
