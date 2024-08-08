<?php

declare(strict_types=1);

namespace App\Php94\Installer\Http;

use PHP94\Factory;
use PHP94\Request;
use Psr\Http\Message\ResponseInterface;

class File extends Common
{
    public function get(): ResponseInterface
    {
        switch (Request::get('file')) {
            case 'mdjs':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../static/markdown-it.js'));
                return $response;
                break;
            default:
                return Factory::createResponse(404);
                break;
        }
    }
}
