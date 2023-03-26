<?php
return [
  'client.order.service' => function (\Psr\Container\ContainerInterface $c) {
    return new \GuzzleHttp\Client([
      'base_uri' => $c->get('order.service.uri'),
      'timeout' => $c->get('timeout.request.HTTP'),
    ]);
  },

  'client.catalog.service' => function (\Psr\Container\ContainerInterface $c) {
    return new \GuzzleHttp\Client([
      'base_uri' => $c->get('catalog.service.uri'),
      'timeout' => $c->get('timeout.request.HTTP'),
    ]);
  },

  'client.auth.service' => function (\Psr\Container\ContainerInterface $c) {
    return new \GuzzleHttp\Client([
      'base_uri' => $c->get('auth.service.uri'),
      'timeout' => $c->get('timeout.request.HTTP'),
    ]);
  },
];
