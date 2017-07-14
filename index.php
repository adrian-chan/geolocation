<?php

require 'vendor/autoload.php';
require 'bootstrap.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) {
    echo "test";
});

$app->get('/providers', function (Request $request, Response $response) {
    echo "TEST GEO PROVIDERS";
    $address = '56 Hay Street Subiaco, Perth , Western Australia';

    $lat = -32.038492;
    $lon = 115.834519;

    //$curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
    $adapter = new \Ivory\HttpAdapter\Guzzle6HttpAdapter();

    $geocoder = new \Geocoder\Provider\GoogleMaps($adapter);

    /*    $t = $geocoder->geocode($address);

        var_dump($t->all());
    */

    echo "<h1>Google Maps</h1>";

    $h = $geocoder->reverse($lat, $lon);
    var_dump($h->all());
    var_dump($h->first()->getLocality());
    var_dump($h->first()->getSubLocality());


    echo "<h1>Open Street Map</h1>";
    $openStreetMap = new \Geocoder\Provider\OpenStreetMap($adapter);
    $g = $openStreetMap->reverse($lat, $lon);

    var_dump($g->all());
    var_dump($g->first()->getLocality());
    var_dump($g->first()->getSubLocality());


    echo "<h1>MapQuest</h1>";
    $geonames = new \Geocoder\Provider\MapQuest($adapter, getenv('MAPQUEST_API_KEY'));
    $g = $geonames->reverse($lat, $lon);

    var_dump($g->all());
    var_dump($g->first()->getLocality());
    var_dump($g->first()->getSubLocality());

    echo "<h1>OpenCage</h1>";
    $geonames = new \Geocoder\Provider\OpenCage($adapter, getenv('OPENCAGE_API_KEY'));
    $g = $geonames->reverse($lat, $lon);

    var_dump($g->all());
    var_dump($g->first()->getLocality());
    var_dump($g->first()->getSubLocality());

    echo "<h1>BingMaps</h1>";
    $geonames = new \Geocoder\Provider\BingMaps($adapter, getenv('BINGMAPS_API_KEY'));
    $g = $geonames->reverse($lat, $lon);

    var_dump($g->all());
    var_dump($g->first()->getLocality());
    var_dump($g->first()->getSubLocality());
});


$app->get('/google-maps', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    $lon = $params['lon'];
    $lat = $params['lat'];

    $result = $this->geocoder->reverse($lat, $lon);

    //var_dump($result->all());
    $g = $result->getIterator();

    var_dump($g);
    /*$response
        ->withHeader('content-type', 'application/json')
        ->write(json_encode($result->all()), JSON_PRETTY_PRINT);*/
});

$app->run();

?>