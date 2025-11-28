<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Modelos\User;

class TokenMiddleware {
    public function __invoke(Request $request, Response $response, $next) {
        $auth = $request->getHeader('Authorization');

        if (!$auth) {
            $response->getBody()->write(json_encode(['error'=>'Token no enviado']));
            return $response->withStatus(401)
                            ->withHeader('Content-Type','application/json');
        }

        $token = str_replace('Bearer ','',$auth[0]);
        $usuario = User::where('token', $token)->first();

        if(!$usuario){
            $response->getBody()->write(json_encode(['error'=>'Token inválido']));
            return $response->withStatus(401)
                            ->withHeader('Content-Type','application/json');
        }

        $request = $request->withAttribute('usuario',$usuario);

        return $next($request, $response);
    }
}
