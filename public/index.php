<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, false, false);
$errorMiddleware->getDefaultErrorHandler()->forceContentType('application/json');

$errorMiddleware->getDefaultErrorHandler()->registerErrorRenderer('application/json', lbs\gateway\errors\renderer\JsonErrorRenderer::class);


/**
 * API Basic Route
 */
$app->get('/', lbs\gateway\actions\HomeAction::class);


/**
 * API Order Service
 */
$app->get('/orders[/]', lbs\gateway\actions\orders\GetOrdersAction::class);
$app->post('/orders[/]', lbs\gateway\actions\orders\NewOrderAction::class);

$app->run();
