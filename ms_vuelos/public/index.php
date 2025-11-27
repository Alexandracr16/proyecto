<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Configuracion/database.php';

use Slim\Factory\AppFactory;
use App\Controladores\NavesController;
use App\Middleware\TokenMiddleware;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Rutas protegidas (admin/gestor)
$app->group('', function($group){
    $group->get('/naves', [NavesController::class,'listar']);
    $group->post('/naves', [NavesController::class,'crear']);
})->add(new TokenMiddleware());

$app->run();
