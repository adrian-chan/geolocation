<?php

require 'vendor/autoload.php';
require 'bootstrap.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/', function(Request $request, Response $response) {

    echo 'blah';
});

$app->run();

?>