<?php

namespace lbs\gateway\actions\orders;

use lbs\gateway\actions\AbstractAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class NewOrderAction extends AbstractAction
{
  public function __invoke(
    Request $rq,
    Response $rs
  ): Response {
    $query = $rq->getQueryParams();

    $client = $this->container->get('client.order.service');
    $responseHTTP = $client->post('/orders', [
      'query' => $query,
      'headers' => [
        'Authorization' => $rq->getHeader('Authorization')[0],
        'Content-Type' => $this->container->get('content.type')
      ],
      'body' => json_encode($rq->getParsedBody())
    ]);

    $logger = $this->container->get('logger');
    $logger->info("NewOrderAction | POST | {$this->container->get('order.service.uri')}/orders | {$responseHTTP->getStatusCode()}");

    return $responseHTTP;
  }
}
