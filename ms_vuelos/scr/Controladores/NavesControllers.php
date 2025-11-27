<?php
namespace App\Controladores;

use App\Modelos\Nave;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class NavesController {

    // Listar todas las naves
    public function listar(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $naves = Nave::all();
        $response->getBody()->write($naves->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Crear nave
    public function crear(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $data = $request->getParsedBody();
        $nave = Nave::create($data);

        $response->getBody()->write($nave->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Actualizar nave
    public function actualizar(Request $request, Response $response, $args){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $nave = Nave::find($args['id']);
        if(!$nave){
            $response->getBody()->write(json_encode(['error'=>'Nave no encontrada']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $nave->update($request->getParsedBody());
        $response->getBody()->write($nave->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Eliminar nave
    public function eliminar(Request $request, Response $response, $args){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'administrador'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $nave = Nave::find($args['id']);
        if(!$nave){
            $response->getBody()->write(json_encode(['error'=>'Nave no encontrada']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $nave->delete();
        $response->getBody()->write(json_encode(['mensaje'=>'Nave eliminada']));
        return $response->withHeader('Content-Type','application/json');
    }
}
