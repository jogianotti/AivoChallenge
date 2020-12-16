<?php

use AivoChallenge\Domain\AlbumsFieldsExtractor;
use AivoChallenge\Domain\AlbumsSearcher;
use AivoChallenge\IO\SpotifyService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Container;
use Symfony\Component\Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$container = new Container();
$container['albums_searcher'] = function () {
    return new AlbumsSearcher(new SpotifyService());
};
$container['albums_fields_extractor'] = function () {
    return new AlbumsFieldsExtractor();
};

$app = new App($container);

$app->get('/api/v1/albums', function (Request $request, Response $response) {
    $parameters = $request->getQueryParams();
    $albums_searcher = $this->get('albums_searcher');
    $albums_fields_extractor = $this->get('albums_fields_extractor');

    try {
        $albums = $albums_searcher($parameters['q']);
        $data = $albums_fields_extractor($albums);
    } catch (\Exception $e) {
        $data = ['error' => $e->getMessage()];
    }

    return $response->withJson($data);
});

$app->run();