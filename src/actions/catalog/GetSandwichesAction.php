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

    $client = $this->container->get('client.order.service');

    $responseHTTP = $client->get('/items/sandwiches', [
      'query' => $query,
      'headers' => [
        // 'Authorization' => 'bearer ...',
        'Content-Type' => $this->container->get('content.type')
      ]
    ]);

    $logger = $this->container->get('logger');
    $logger->info("GetSandwichesAction | GET | {$this->container->get('catalog.service.uri')}/orders | {$responseHTTP->getStatusCode()}");

    return $responseHTTP;
  }
}
