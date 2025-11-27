<?php
namespace App\Controladores;

use App\Modelos\Flight;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VuelosController {

    // Listar vuelos
    public function listar(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $vuelos = Flight::all();
        $response->getBody()->write($vuelos->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Crear vuelo
    public function crear(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $data = $request->getParsedBody();
        $vuelo = Flight::create($data);
        $response->getBody()->write($vuelo->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Actualizar vuelo
    public function actualizar(Request $request, Response $response, $args){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $vuelo = Flight::find($args['id']);
        if(!$vuelo){
            $response->getBody()->write(json_encode(['error'=>'Vuelo no encontrado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $vuelo->update($request->getParsedBody());
        $response->getBody()->write($vuelo->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Eliminar vuelo
    public function eliminar(Request $request, Response $response, $args){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $vuelo = Flight::find($args['id']);
        if(!$vuelo){
            $response->getBody()->write(json_encode(['error'=>'Vuelo no encontrado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $vuelo->delete();
        $response->getBody()->write(json_encode(['mensaje'=>'Vuelo eliminado']));
        return $response->withHeader('Content-Type','application/json');
    }
}