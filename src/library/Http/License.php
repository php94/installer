<?php

declare(strict_types=1);

namespace App\Php94\Installer\Http;

use Composer\Autoload\ClassLoader;
use PHP94\Template;
use PHP94\Response;
use ReflectionClass;

class License extends Common
{
    public function get()
    {
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        if (!file_exists($root . '/LICENSE')) {
            return Response::error('授权文件不存在，请确认是否通过官方渠道下载');
        }
        return Template::render('license@php94/installer', [
            'license' => file_get_contents($root . '/LICENSE'),
        ]);
    }
}
