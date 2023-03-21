<?php

namespace lbs\gateway\actions\orders;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class NewOrderAction
{
  public function __invoke(
    Request $rq,
    Response $rs
  ): Response {
    $query = $rq->getQueryParams();

    $client = new Client([
      'base_uri' => 'http://api.order.local',
      'timeout' => 2.0,
    ]);
    $responseHTTP = $client->post('/orders', [
      'query' => $query,
      'headers' => [
        // 'Authorization' => 'bearer ...',
        'Content-Type' => 'application/json'
      ],
      'body' => json_encode($rq->getParsedBody())
    ]);

    return $responseHTTP;
  }
}
