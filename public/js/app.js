$(document).ready(function () {
    const $placesList = $('#placesList');
    const $loading = $('.loading-overlay');
    const $additionalInfo = $('#additional-info');
    const $welcomeMessageContainer = $('#welcome-message');
    const welcomeMessage = 'Welcome to WeatherApp';

    // Display welcome message
    $welcomeMessageContainer.text(welcomeMessage);

    // Initial load for Tokyo
    getWeatherAndPlacesInfo('tokyo');
    $loading.fadeIn();

    // Event handler for Get Information button
    $('#getInfo').click(function () {
        const selectedCity = $('#city').val();

        // Show loader with fadeIn animation
        $loading.fadeIn();
        getWeatherAndPlacesInfo(selectedCity);
    });

    function displayPlacesInfo(placesData) {
        $placesList.empty();

        if (placesData && isValidPlacesData(placesData)) {
            displayCategory('Attractions/Landmarks', placesData.attractions);
            displayCategory('Transportation', placesData.transportation);
            displayCategory('Accommodation', placesData.accommodation);
        } else {
            $placesList.append('<li>No location information available.</li>').find('li').fadeIn();
        }
    }

    function isValidPlacesData(placesData) {
        return (
            Array.isArray(placesData.attractions) &&
            Array.isArray(placesData.transportation) &&
            Array.isArray(placesData.accommodation)
        );
    }

    function displayCategory(category, data) {
        $placesList.append(`<li id="category"><strong>${category}:</strong></li>`);

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(item => $placesList.append(`<li>${item}</li>`).find('li').fadeIn());
        } else {
            $placesList.append('<li>No data available for this category.</li>').find('li').fadeIn();
        }
    }

    function displayForecast(forecastData) {
        const forecastContainer = $("#weather-forecast");
        forecastContainer.empty();

        for (const day in forecastData) {
            if (forecastData.hasOwnProperty(day)) {
                const dayInfo = forecastData[day][0];

                forecastContainer.append(`
                    <div class="col">
                        <h3>${day}</h3>
                        <img src="${dayInfo.icon}" /><br />
                        <p class="weather">${dayInfo.weather}</p>
                        <span>${dayInfo.temperature}°C</span>
                    </div>
                `).find('.col').fadeIn();
            }
        }
    }

    function getWeatherAndPlacesInfo(selectedCity) {
        // Fetch weather information
        $.get(`/weather/${selectedCity}`, function (weatherData) {
            displayForecast(weatherData);
        });

        // Fetch places information
        $.get(`/places/${selectedCity}`, function (placesData) {
            displayPlacesInfo(placesData);
        }).always(function () {
            $loading.fadeOut();

            if ($placesList.children().length > 0) {
                $additionalInfo.fadeIn();
            } else {
                $additionalInfo.fadeOut();
            }
        });
    }
});
