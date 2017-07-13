<?php
    $container = new \Slim\Container;

    /*
     * DEPENDENCY INJECTORS
     *
     */

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

    $app = new \Slim\App($container);
?>