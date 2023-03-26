<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use lbs\gateway\middlewares\TokenMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$builder = new DI\ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__, 1) . '/conf/settings.php');
$builder->addDefinitions(dirname(__DIR__, 1) . '/conf/guzzleLibrary.php');
$builder->addDefinitions(dirname(__DIR__, 1) . '/conf/logger.php');
$container = $builder->build();

$app = AppFactory::createFromContainer($container);
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(
  $container->get('error.displayErrorDetails'),
  $container->get('error.logErrors'),
  $container->get('error.logErrorDetails'),
  $container->get('logger')
);
$errorMiddleware->getDefaultErrorHandler()->forceContentType('application/json');

$errorMiddleware->getDefaultErrorHandler()->registerErrorRenderer('application/json', lbs\gateway\errors\renderer\JsonErrorRenderer::class);


/**
 * API Basic Route
 */
$app->get('/', lbs\gateway\actions\HomeAction::class);


/**
 * API Order Service
 */
$app->get('/orders[/]', lbs\gateway\actions\orders\GetOrdersAction::class)->add(new TokenMiddleware($container));
$app->post('/orders[/]', lbs\gateway\actions\orders\NewOrderAction::class)->add(new TokenMiddleware($container));



/**
 * API Catalogue Service
 */
$app->get('/sandwiches[/]', lbs\gateway\actions\catalog\GetSandwichesAction::class);
$app->get('/sandwiches/{id}[/]', lbs\gateway\actions\catalog\GetSandwicheByIdAction::class);


/**
 * API Auth Service
 */
$app->post('/signin[/]', lbs\gateway\actions\auth\SignInAction::class);


$app->run();
