<?php
namespace App\Controladores;

use App\Modelos\Reservation;
use App\Modelos\Flight;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReservasController {

    // Listar reservas
    public function listar(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'gestor'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $reservas = Reservation::all();
        $response->getBody()->write($reservas->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Crear reserva
    public function crear(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'gestor'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $data = $request->getParsedBody();

        // Validar que el vuelo existe
        $vuelo = Flight::find($data['flight_id']);
        if(!$vuelo){
            $response->getBody()->write(json_encode(['error'=>'Vuelo no existe']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $reserva = Reservation::create([
            'user_id' => $data['user_id'],
            'flight_id' => $data['flight_id'],
            'status' => 'activa'
        ]);

        $response->getBody()->write($reserva->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Cancelar reserva
    public function cancelar(Request $request, Response $response, $args){
        $usuario = $request->getAttribute('usuario');
        if($usuario->role !== 'gestor'){
            $response->getBody()->write(json_encode(['error'=>'No autorizado']));
            return $response->withHeader('Content-Type','application/json')->withStatus(403);
        }

        $reserva = Reservation::find($args['id']);
        if(!$reserva){
            $response->getBody()->write(json_encode(['error'=>'Reserva no encontrada']));
            return $response->withHeader('Content-Type','application/json')->withStatus(404);
        }

        $reserva->status = 'cancelada';
        $reserva->save();

        $response->getBody()->write(json_encode(['mensaje'=>'Reserva cancelada']));
        return $response->withHeader('Content-Type','application/json');
    }
}