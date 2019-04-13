<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/novinky', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'news.twig', $args);
})->setName('news');

$app->get('/mapa', function(Request $request, Response $response, array $args) {
	// Sample log message
	$this->logger->info('Route map');

	// Render index view
	return $this->view->render($response, 'map.twig', $args);
})->setName('map');

$app->get('/programy', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'programs.twig', $args);
})->setName('programs');

$app->get('/odkazy', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'links.twig', $args);
})->setName('links');

$app->get('/', function(Request $request, Response $response, array $args) {
	// Sample log message
	$this->logger->info('Route /');

	// Render index view
	return $this->view->render($response, 'homepage.twig', $args);
})->setName('homepage');
