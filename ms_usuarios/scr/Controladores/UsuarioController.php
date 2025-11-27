<?php
namespace App\Controladores;

use App\Modelos\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioController {

    // Listar usuarios (solo admin)
    public function listar(Request $request, Response $response){
        $usuarios = User::all();
        $response->getBody()->write($usuarios->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Registrar usuario (solo admin)
    public function registrar(Request $request, Response $response){
        $data = $request->getParsedBody();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $usuario = User::create($data);
        $response->getBody()->write($usuario->toJson());
        return $response->withHeader('Content-Type','application/json');
    }

    // Login
    public function login(Request $request, Response $response){
        $data = $request->getParsedBody();
        $usuario = User::where('email',$data['email'])->first();

        if(!$usuario || !password_verify($data['password'],$usuario->password)){
            $response->getBody()->write(json_encode(['error'=>'Usuario o contraseña incorrecta']));
            return $response->withHeader('Content-Type','application/json')->withStatus(401);
        }

        $token = bin2hex(random_bytes(16));
        $usuario->token = $token;
        $usuario->save();

        $response->getBody()->write(json_encode(['token'=>$token,'rol'=>$usuario->role]));
        return $response->withHeader('Content-Type','application/json');
    }

    // Logout
    public function logout(Request $request, Response $response){
        $usuario = $request->getAttribute('usuario');
        $usuario->token = null;
        $usuario->save();

        $response->getBody()->write(json_encode(['mensaje'=>'Sesión cerrada']));
        return $response->withHeader('Content-Type','application/json');
    }
}
