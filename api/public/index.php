<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require_once '../lib/controller/UserCtrl.php';
include_once '../lib/controller/GoogleClientCtrl.php';
include_once '../lib/controller/BadgesBoardCtrl.php';

include_once '../lib/model/Badge.php';

/**
 * Enable CORS
 */
if (isset($_SERVER['HTTP_ORIGIN'])) {
   header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
   header('Access-Control-Allow-Credentials: true');
   header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

   if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

   if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

$configuration = [
   'settings' => [
      'displayErrorDetails' => true,
   ],
];
$config = new \Slim\Container($configuration);

$app = new \Slim\App($config);

$app->get('/leaderboard', function (Request $request, Response $response) {
   $userCtrl = new UserController();
   $leaderBoard = $userCtrl->getUserRanking();

   $response->getbody()->write(json_encode($leaderBoard));

});

$app->get('/badgesboard', function (Request $request, Response $response) {
   $badgesBoardCtrl = new BadgesBoardCtrl();
   $badgesBoard = $badgesBoardCtrl->getBadgesBoard();

   $response->getbody()->write(json_encode($badgesBoard));

});


$app->run();