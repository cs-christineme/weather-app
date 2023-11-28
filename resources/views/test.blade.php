<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Tourist App</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add other styles and scripts as needed -->
    <style>
        /* Your styles remain unchanged */
    </style>
</head>
<body>
<div id="app">
    <h1>Weather and Places Information</h1>
    <label for="city">Select City:</label>
    <select id="city">
        <option value="Tokyo">Tokyo</option>
        <option value="Yokohama">Yokohama</option>
        <option value="Kyoto">Kyoto</option>
        <option value="Osaka">Osaka</option>
        <option value="Sapporo">Sapporo</option>
        <option value="Nagoya">Nagoya</option>
    </select>
    <button id="getInfo">Get Information</button>
    <div id="weatherInfo">
        <h2>Weather Information</h2>
        <ul id="weatherList"></ul>
    </div>
    <div id="placesInfo">
        <h2>Places Information</h2>
        <ul id="placesList"></ul>
    </div>
</div>
<!-- Add this part to the script tag in your existing HTML file -->
<script>
    $(document).ready(function() {
        $('#getInfo').click(function() {
            var selectedCity = $('#city').val();

            // Fetch weather information
            $.get(`/weather/${selectedCity}`, function(weatherData) {
                // Display weather information on the page
                displayWeatherInfo(weatherData);
            });

            // Fetch places information
            $.get(`/places/${selectedCity}`, function(placesData) {
                // Display places information on the page
                displayPlacesInfo(placesData);
            });
        });

        function displayWeatherInfo(weatherData) {
            var $weatherList = $('#weatherList');
            $weatherList.empty();

            // Loop through each day
            $.each(weatherData, function(day, items) {
                // Display only the first item for each day
                var item = items[0];
                $weatherList.append(`<li><strong>${day}</strong> - Date: ${item.date}, Temperature: ${item.temperature}F, Description: ${item.description}</li>`);
            });
        }

        function displayPlacesInfo(placesData) {
            var $placesList = $('#placesList');
            $placesList.empty();

            placesData.forEach(function(place) {
                $placesList.append(`<li>City: ${place.city}, Country: ${place.country}, Address: ${place.formatted_address}</li>`);
            });
        }
    });
</script>

</body>
</html>
