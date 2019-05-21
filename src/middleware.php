<?php

namespace App;

use Slim\App;

/** @var $app App */
$app->add(new \Slim\Middleware\Session([
    'name' => 'obrok19',
    'autorefresh' => true,
    'lifetime' => '7 days'
]));


$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));
