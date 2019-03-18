<?php

namespace Github;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiController
{
    private $client;
    private $response;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function index(ServerRequestInterface $request)
    {
        // Criando e modificando o uri da request
        $uri = $request->getUri()->withHost('api.github.com')->withScheme('https')->withPort(443);
        $request = $request->withUri($uri);

        // Executando a request usando promise
        $promise = $this->client->sendAsync($request);
        $promise->then(function (ResponseInterface $response) {
            $this->response = $response
                ->withoutHeader('Transfer-Encoding') // chunked
                ->withoutHeader('Content-Encoding'); // deflate
        });

        // Importando para só continuar o processamento após o retorno da promise
        $promise->wait();

        return $this->response;
    }
}
