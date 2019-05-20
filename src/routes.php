<?php

namespace App;

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/novinky', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'news.twig', $args);
})->setName('news');

$app->get('/mapa', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'map.twig', $args);
})->setName('map');

$app->get('/programy', function(Request $request, Response $response, array $args) {
	$httpService = new HttpService();
	$programSections = $httpService->getSectionsLocal();
	$programs = $httpService->getPrograms();
	foreach ($programs as $program) {
		$programSections[$program['section']['id']]['programs'][] = $program;
	}

	return $this->view->render($response, 'programs.twig', ['sections' => $programSections]);
})->setName('programs');

$app->get('/harmonogram', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'harmonogram.twig', $args);
})->setName('harmonogram');

$app->get('/handbook', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'handbook.twig', $args);
})->setName('handbook');

$app->post('/save-subscription', function(Request $request, Response $response, array $args) {
	$json = json_decode($request->getBody(), true);

	// save substription

	return $response->withJson(['message' => 'success']);
});

$app->get('/', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'homepage.twig', $args);
})->setName('homepage');
