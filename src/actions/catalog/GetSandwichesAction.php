<?php

namespace lbs\gateway\actions\catalog;

use lbs\gateway\actions\AbstractAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class GetSandwichesAction extends AbstractAction
{
  public function __invoke(
    Request $rq,
    Response $rs
  ): Response {
    $query = $rq->getQueryParams();

    $client = $this->container->get('client.catalog.service');

    $responseHTTP = $client->get('/items/sandwiches', [
      'query' => $query,
      'headers' => [
        'Authorization' => $rq->getHeader('Authorization')[0],
      ]
    ]);

    $logger = $this->container->get('logger');
    $logger->info("GetSandwichesAction | GET | {$this->container->get('catalog.service.uri')}/items/sandwiches | {$responseHTTP->getStatusCode()}");

    return $responseHTTP;
  }
}
