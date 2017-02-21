<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require_once '../lib/controller/AssetsCtrl.php';
require_once '../lib/controller/UserCtrl.php';
require_once '../lib/controller/LegendCtrl.php';
include_once '../lib/controller/GoogleClientCtrl.php';
include_once '../lib/controller/BadgesBoardCtrl.php';

include_once '../lib/model/Badge.php';

include_once '../lib/common/UtilsService.php';

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
//$config = new \Slim\Container($configuration);

$app = new \Slim\Slim($configuration);

$app->get('/leaderboard', function ()  use ($app) {
   $userCtrl = new UserController();
   $leaderBoard = $userCtrl->getUserRanking();

   $app->response->write(json_encode($leaderBoard));
});

$app->get('/assets', function ()  use ($app) {
   $assetsCtrl = new AssetsController();
   $assets = $assetsCtrl->getAssets();

   $app->response->write(json_encode($assets));
});

$app->get('/legend', function ()  use ($app) {
   $legendCtrl = new LegendController();
   $legend = $legendCtrl->getLegendContent();

   $app->response->write(json_encode($legend));
});

$app->get('/badgesboard', function ()   use ($app) {
   $badgesBoardCtrl = new BadgesBoardCtrl();
   $badgesBoard = $badgesBoardCtrl->getBadgesBoard();

   $app->response->write(json_encode($badgesBoard));
});


$app->run();
