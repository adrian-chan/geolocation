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

/*
 * GOOGLE MAPS GEOCODER
 *
 */
$app->get('/google-maps', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    //$lon = $params['lon'];
    //$lat = $params['lat'];

    $lat = -32.038492;
    $lon = 115.834519;

    $result = $this->geocoder->using('google_maps')->reverse($lat, $lon);
    $resultJson = geoJsonObjects::mapJson($result);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write($resultJson, JSON_PRETTY_PRINT);
});

/*
 * OPEN STREET MAP GEOCODER
 *
 *
 */
$app->get('/open-street-map', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    //$lon = $params['lon'];
    //$lat = $params['lat'];

    $lat = -32.038492;
    $lon = 115.834519;

    $result = $this->geocoder->using('openstreetmap')->reverse($lat, $lon);
    $resultJson = geoJsonObjects::mapJson($result);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write($resultJson, JSON_PRETTY_PRINT);
});

$app->get('/map-quest', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    //$lon = $params['lon'];
    //$lat = $params['lat'];

    $lat = -32.038492;
    $lon = 115.834519;

    $result = $this->geocoder->using('map_quest')->reverse($lat, $lon);
    $resultJson = geoJsonObjects::mapJson($result);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write($resultJson, JSON_PRETTY_PRINT);
});

$app->get('/open-cage', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    //$lon = $params['lon'];
    //$lat = $params['lat'];

    $lat = -32.038492;
    $lon = 115.834519;

    $result = $this->geocoder->using('opencage')->reverse($lat, $lon);
    $resultJson = geoJsonObjects::mapJson($result);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write($resultJson, JSON_PRETTY_PRINT);
});

$app->get('/bing-maps', function (Request $request, Response $response) {

    // init params;
    $params = $request->getQueryParams();
    //$lon = $params['lon'];
    //$lat = $params['lat'];

    $lat = -32.038492;
    $lon = 115.834519;

    $result = $this->geocoder->using('bing_maps')->reverse($lat, $lon);
    $resultJson = geoJsonObjects::mapJson($result);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write($resultJson, JSON_PRETTY_PRINT);
});


$app->run();

class geoJsonObjects {

    static public function mapJson (\Geocoder\Model\AddressCollection $result)
    {
        $result = $result->all();
        $results = [];
        $i = 0;
        while ($i < count($result)) {
            $results[$i]['coordinates'] = $result[$i]->getcoordinates();
            $results[$i]['locality'] = $result[$i]->getLocality();
            $results[$i]['sublocality'] = $result[$i]->getSubLocality();
            $results[$i]['streetname']  = $result[$i]->getStreetName();
            $results[$i]['streetno']  = $result[$i]->getStreetNumber();
            $results[$i]['postcode']  = $result[$i]->getPostalCode();
            $results[$i]['timezone']  = $result[$i]->getTimezone();
            $i++;
        }

        return json_encode($results, JSON_PRETTY_PRINT);
    }
}

//function returnArrayMap( $results );
?>