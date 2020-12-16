<?php

use AivoChallenge\AlbumsFieldsExtractor;
use AivoChallenge\AlbumsSearcher;
use AivoChallenge\SpotifyService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Container;

require '../vendor/autoload.php';

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

    $albums = $albums_searcher($parameters['q']);
    $albums_array = $albums_fields_extractor($albums);

    return $response->withJson($albums_array);
});

$app->run();