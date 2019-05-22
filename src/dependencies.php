<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Skautis\Skautis;
use Slim\App;
use Slim\Container;
use Slim\Http\Uri;
use Slim\Router;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


/** @var $app App */
$container = $app->getContainer();

$container['logger'] = function(Container $c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Logger($settings['name']);
	$logger->pushProcessor(new UidProcessor());
	$logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
	return $logger;
};


$container['skautis'] = function (Container $c) {
    $settings = $c->get('settings')['skautis'];
    return Skautis::getInstance($settings['appId'], $settings['testMode']);
};

// Register globally to app
$container['session'] = function (Container $c) {
    return new \SlimSession\Helper;
};

// Register globally to app
$container['authenticator'] = function (Container $c) {
    return new Authenticator($c->get('session'), $c->get('skautis'));
};


$container['view'] = function(Container $c) {
	$view = new Twig(__DIR__.'/../templates/', [
		//'cache' => '/../temp/viewcache'
		'cache' => false,
	]);

	/** @var Router $router */
	$router = $c->get('router');

	/** @var Uri $uri */
//	$uri = $c['request']->getUri();
//	$basePath = $uri->getScheme().'://'.$uri->getHost().':'.$uri->getPort().$uri->getBasePath();
    $basePath = '';



	$view->addExtension(new TwigExtension($router, $basePath));

	$view->getEnvironment()->addFunction(
		new TwigFunction('link', function($routeName) use ($router, $basePath) {
			/** @var \Slim\Router $router */
			return $router->pathFor($routeName);
		})
	);

	$view->getEnvironment()->addFilter(new TwigFilter('dateToCzechDayName', function($datetimeArray) {
		$engShortStringDay = (new \DateTime($datetimeArray['date']))->format('D');
		$czechTranslation = [
			'Mon' => 'pondělí',
			'Tue' => 'úterý',
			'Wed' => 'středa',
			'Thu' => 'čtvrtek',
			'Fri' => 'pátek',
			'Sat' => 'sobota',
			'Sun' => 'neděle',
		];
		return $czechTranslation[$engShortStringDay];
	}));

	return $view;
};

