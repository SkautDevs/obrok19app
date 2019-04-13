<?php

$container = $app->getContainer();

// monolog
$container['logger'] = function($c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	return $logger;
};

$container['view'] = function($c) {
	$view = new \Slim\Views\Twig(__DIR__.'/../templates/', [
		//'cache' => '/../temp/viewcache'
		'cache' => false,
	]);

	$router = $c->get('router');
	$uri = $c['request']->getUri();
	$basePath = $uri->getScheme().'://'.$uri->getHost().':'.$uri->getPort().$uri->getBasePath();

	$view->addExtension(new \Slim\Views\TwigExtension($router, $basePath));

	$view->getEnvironment()->addFunction(
		new \Twig\TwigFunction('link', function(string $routeName) use ($router, $basePath) {
			/** @var \Slim\Router $router */
			return $basePath.$router->pathFor($routeName);
		}));

	return $view;
};
