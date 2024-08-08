<?php

declare(strict_types=1);

namespace App\Php94\Installer\Http;

use Composer\Autoload\ClassLoader;
use PHP94\Template;
use PHP94\Response;
use ReflectionClass;

class Readme extends Common
{
    public function get()
    {
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        if (!file_exists($root . '/README.md')) {
            return Response::error('系统介绍不存在，请确认是通过官方渠道下载');
        }
        return Template::render('readme@php94/installer', [
            'readme' => file_get_contents($root . '/README.md'),
        ]);
    }
}
