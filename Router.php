<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

$app = AppFactory::create();
// $app->setBasePath('php-api'); // Subdirectory angeben

// http://www.slimframework.com/docs/v4/cookbook/enable-cors.html
$app->options('/backend/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

// Parse Json - Form Data und XML 
$app->addBodyParsingMiddleware();

// Cors Settings
$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response->withHeader('Access-Control-Allow-Origin', 'localhost')->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



$app->get('/', function (Request $request, Response $response) {
  $response->getBody()->write("");
  return $response;
});

// C(R)UD - READ - über HTTP Anfrage Methode GET
$app->get('/api/getQuestion', function (Request $request, Response $response) {
  require_once('./App/Controllers/QuestionController.php');
  $questionController = new App\Controllers\QuestionController();
  $question = $questionController->randomQuestion();
  $payload = json_encode($question);
  $response->getBody()->write($payload); 
  return $response;

});


// (C)RUD - CREATE - über HTTP Anfrage Methode POST

/*

$app->post('/api/todo', function (Request $request, Response $response) {
  $db = new DbHandler();
  $data = json_decode($request->getBody(), true);
  $result = $db->addTodo($data['text']);

  $payload = json_encode($result, JSON_PRETTY_PRINT);
  $response->getBody()->write($payload);
  return $response;
});

*/

$app->run();

/**
 * Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
  throw new HttpNotFoundException($request);
});
