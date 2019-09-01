# About this Repo
Small Project on laravel 5.8 Rest Api with third party APIs and feature tests

## Before Installation
1. Install Composer ( https://getcomposer.org/download/ )
2. Install Laravel 5.8 ( https://laravel.com/docs/5.8/installation )

## Installation
1. Clone the repo and cd into it
2. composer install
3. php artisan serve or use Laravel Valet or Laravel Homestead
4. Use GET API's http://localhost:8000/api/details with GET request data <b>e.x.</b><br>
    a. http://localhost:8000/api/details?sourceId=space&year=2013&limit=2  <br>
    b. http://localhost:8000/api/get-details?sourceId=comics&comicId=77  <br>
5. I have used Spatie\ResponseCache library for caching of responses and added it to "/api/details" route. This will cache API request for 7 days(by default) and call "/api/details" GET request with same data only once and return cache data afterwords.
To clear cache use terminal code - "php artisan responsecache:clear".
    
## Code Details
1. <b>/tests/Feature/DetailsFeatureTest.php</b> - Feature Test for API request "/api/details" <br>
2. <b>/routes/api</b> - Api route containing GET api route request "/api/details" <br>
3. <b>/app/Http/Controllers/DetailsController.php</b> - Controller containing function implementation of route "/api/details"<br>
4. <b>/app/Http/Requests/DetailRequest.php</b> - Contains Request for validation of DetailsController requests data.<br>

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
