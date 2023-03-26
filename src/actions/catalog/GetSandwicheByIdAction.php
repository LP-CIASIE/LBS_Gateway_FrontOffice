<?php

namespace lbs\gateway\actions\catalog;

use lbs\gateway\actions\AbstractAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class GetSandwicheByIdAction extends AbstractAction
{
  public function __invoke(
    Request $rq,
    Response $rs,
    array $args
  ): Response {
    $query = $rq->getQueryParams();

    $client = $this->container->get('client.catalog.service');

    $responseHTTP = $client->get("/items/sandwiches/{$args['id']}", [
      'query' => $query,
      'headers' => [
        'Authorization' => $rq->getHeader('Authorization')[0],
      ]
    ]);

    $logger = $this->container->get('logger');
    $logger->info("GetSandwichesAction | GET | {$this->container->get('catalog.service.uri')}/items/sandwiches/{$args['id']} | {$responseHTTP->getStatusCode()}");

    return $responseHTTP;
  }
}
