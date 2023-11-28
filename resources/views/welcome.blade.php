<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Oxygen+Mono&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Weather App</title>
</head>
<body>
    <main>
        <div id="welcome-message"></div>
        <!-- search bar and city name -->
        <div id="app">
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
        </div>


        <section class="container">
            <div class="row week-forecast" id="weather-forecast">
            </div>
        </section>
        <!-- Display weather forecast -->
        <section class="container">
            <!-- Display places information -->
            <div>
                <h3 id="additional-info">Additional Information</h3>
                <ul id="placesList" style="position: relative;">
                    <!-- Loading animation -->
                </ul>
            </div>
            <div class="loading-overlay" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
