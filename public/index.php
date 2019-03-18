<?php

require_once __DIR__.'/../vendor/autoload.php';

// Criando a request e o manipulador
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals();
$handler = GuzzleHttp\HandlerStack::create();

// Criando o objeto que irá gerenciar o conteúdo do Github
$github = new Github\ApiController(new GuzzleHttp\Client(compact('handler')));

// Buscando o conteúdo da api requisitada
$response = $github->index($request);

// Response
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
