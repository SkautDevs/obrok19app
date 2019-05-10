<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Container;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


$container = $app->getContainer();

$container['logger'] = function($c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Logger($settings['name']);
	$logger->pushProcessor(new UidProcessor());
	$logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
	return $logger;
};

$container['view'] = function(Container $c) {
	$view = new Twig(__DIR__.'/../templates/', [
		//'cache' => '/../temp/viewcache'
		'cache' => false,
	]);

	$router = $c->get('router');
	$uri = $c['request']->getUri();
	$basePath = $uri->getScheme().'://'.$uri->getHost().':'.$uri->getPort().$uri->getBasePath();

	$view->addExtension(new TwigExtension($router, $basePath));

	$view->getEnvironment()->addFunction(
		new TwigFunction('link', function(string $routeName) use ($router, $basePath) {
			/** @var \Slim\Router $router */
			return $basePath.$router->pathFor($routeName);
		})
	);

	$view->getEnvironment()->addFilter(new TwigFilter('dateToCzechDayName', function($datetimeArray) {
		$engShortStringDay = (new \DateTime($datetimeArray['date']))->format('D');
		$czechTranslation = [
			'Mon' => 'pondělí',
			'Tue' => 'úterý',
			'Wen' => 'středa',
			'Thu' => 'čtvrtek',
			'Fri' => 'pátek',
			'Sat' => 'sobota',
			'Sun' => 'neděle',
		];
		return $czechTranslation[$engShortStringDay];
	}));

	return $view;
};
