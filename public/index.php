<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(false, false, false);
$errorMiddleware->getDefaultErrorHandler()->forceContentType('application/json');

$errorMiddleware->getDefaultErrorHandler()->registerErrorRenderer('application/json', lbs\gateway\errors\renderer\JsonErrorRenderer::class);


/**
 * configuring API Routes
 */
$app->get('/', lbs\gateway\actions\HomeAction::class);

$app->run();
