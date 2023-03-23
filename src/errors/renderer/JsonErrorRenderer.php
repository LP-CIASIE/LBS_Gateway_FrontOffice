<?php

namespace lbs\gateway\errors\renderer;

class JsonErrorRenderer extends \Slim\Error\Renderers\JsonErrorRenderer
{
  private $container;

  public function __construct(\Psr\Container\ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(
    \Throwable $exception,
    bool $displayErrorDetails
  ): string {
    $data = [
      'type' => 'error',
      'error' => $exception->getCode(),
      'message' => $exception->getMessage(),
    ];

    if ($displayErrorDetails) $data['details'] = [
      'file' => $exception->getFile(),
      'line' => $exception->getLine(),
      'trace' => $exception->getTraceAsString()
    ];

    return json_encode($data, JSON_PRETTY_PRINT);
  }
}
