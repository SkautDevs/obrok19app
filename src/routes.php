<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/novinky', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'news.twig', $args);
})->setName('news');

$app->get('/mapa', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'map.twig', $args);
})->setName('map');

$app->get('/programy', function(Request $request, Response $response, array $args) {
	$programs = array_fill(0, 4, [
		'name' => 'Přednáška Franty Říhy o plážových povalečích',
		'perex' => 'Je to o plážích a Lorem Ipsum Dolor Sit Amet...',  // null
		'startDatetime' => (new \DateTime())->format('d. m. H:i'),
		'endDatetime' => (new \DateTime('now + 2 hours'))->format('d. m. H:i'),
		'place' => 'zadní louka', // null
		'bringAlong' => 'písek a lehátka',  // null
		'lector' => 'Franta Říha',
		'capacity' => 23,
		'seatsTaken' => 22,
	]);
	$dummyPorgrams = json_encode(array_fill(0, 2, [
			'sectionName' => 'Vapro blok 2',
			'programs' => $programs
		]
	));
	return $this->view->render($response, 'programs.twig', ['sections' => json_decode($dummyPorgrams, true)]);
})->setName('programs');

$app->get('/odkazy', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'links.twig', $args);
})->setName('links');

$app->post('/save-subscription', function(Request $request, Response $response, array $args) {
	$json = json_decode($request->getBody(), true);

	// save substription

	return $response->withJson(['message' => 'success']);
});

$app->get('/', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'homepage.twig', $args);
})->setName('homepage');
