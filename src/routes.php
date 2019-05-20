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
	foreach ($programs as $program)
	{
	    // programy s timto nazvem nechceme
        if ($program['name'] === 'Osobní volno')
        {
            continue;
        }

		$programSections[$program['section']['id']]['programs'][] = $program;
	}

	return $this->view->render($response, 'programs.twig', ['sections' => $programSections]);
})->setName('programs');

$app->get('/harmonogram', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'harmonogram.twig', $args);
})->setName('harmonogram');

$app->get('/handbook', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'handbook-choose.twig', $args);
})->setName('handbook-choose');

$app->get('/handbook/view', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'handbook-view.twig', $args);
})->setName('handbook-view');

$app->get('/handbook/download', function(Request $request, Response $response, array $args) {
	$response = $response
		->withHeader('Content-type', 'application/pdf')
		->withAddedHeader('Content-Disposition', 'attachment;filename="Obrok19_handbook.pdf"')
		->withAddedHeader('Expires', '0');

	readfile('/attachments/obrok19_booklet.pdf');

	return $response;
})->setName('handbook-download');

$app->get('/', function(Request $request, Response $response, array $args) {
	return $this->view->render($response, 'homepage.twig', $args);
})->setName('homepage');
