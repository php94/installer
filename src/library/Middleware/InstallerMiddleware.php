<?php

declare(strict_types=1);

namespace App\Php94\Installer\Middleware;

use PHP94\Facade\Router;
use PHP94\Help\Request;
use PHP94\Help\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class InstallerMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if (0 !== strpos(Request::attr('handler', ''), 'App\\Php94\\Installer\\Http\\')) {
            return Response::error('现在跳转到安装程序', Router::build('/php94/installer/readme'));
        }
        return $handler->handle($request);
    }
}
