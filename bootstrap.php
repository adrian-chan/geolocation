<?php
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    /*
     * DEPENDENCY INJECTORS
     *
     */
    $app = new \Slim\App();

    //$container = new \Slim\Container;
    $container = $app->getContainer();

    //-- MONO LOG
    $container['logger'] = function ($c) {
        $logger = new \Monolog\Logger('my_logger');
        $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
        $logger->pushHandler($file_handler);
        return $logger;
    };


    //-- PLATES TEMPLATING
    $container['template'] = function ($c) {
        $templates = new League\Plates\Engine('templates');

        return $templates;
    };

    $container['geocoder'] = function ($c) {

        $geocoder = new \Geocoder\ProviderAggregator();
        $adapter  = new \Ivory\HttpAdapter\Guzzle6HttpAdapter();

        $geocoder->registerProviders([

            new \Geocoder\Provider\GoogleMaps($adapter)

        ]);

        return $geocoder;

    };

?>