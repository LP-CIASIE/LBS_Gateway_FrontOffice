<?php

namespace lbs\gateway\actions\orders;

use lbs\gateway\actions\AbstractAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class GetOrdersAction extends AbstractAction
{
  public function __invoke(
    Request $rq,
    Response $rs
  ): Response {
    $query = $rq->getQueryParams();

    $client = $this->container->get('client.order.service');

    $responseHTTP = $client->get('/orders', [
      'query' => $query,
      'headers' => [
        'Authorization' => $rq->getHeader('Authorization')[0]
      ]
    ]);


    $logger = $this->container->get('logger');
    $logger->info("GetOrdersAction | GET | {$this->container->get('order.service.uri')}/orders | {$responseHTTP->getStatusCode()}");

    return $responseHTTP;
  }
}
