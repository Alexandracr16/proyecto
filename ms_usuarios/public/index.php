<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Configuracion/database.php';

use Slim\Factory\AppFactory;
use App\Controladores\UsuarioController;
use App\Middleware\TokenMiddleware;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Rutas públicas
$app->post('/login', [UsuarioController::class,'login']);
$app->post('/logout', [UsuarioController::class,'logout']);

// Rutas protegidas
$app->group('', function($group){
    $group->get('/usuarios', [UsuarioController::class,'listar']);
    $group->post('/usuarios', [UsuarioController::class,'registrar']);
})->add(new TokenMiddleware());

$app->run();