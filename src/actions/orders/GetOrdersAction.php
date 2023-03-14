<?php

namespace lbs\gateway\actions\orders;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use GuzzleHttp\Client;

final class GetOrdersAction
{
  public function __invoke(
    Request $rq,
    Response $rs
  ): Response {
    $query = $rq->getQueryParams();

    $client = new Client([
      'base_uri' => 'http://api.order.local:19080',
      'timeout' => 2.0,
    ]);
    $responseHTTP = $client->get('/orders', [
      'query' => $query,
      'headers' => [
        // 'Authorization' => 'bearer ...',
        'Content-Type' => 'application/json'
      ]
    ]);

    return $responseHTTP;
  }
}
