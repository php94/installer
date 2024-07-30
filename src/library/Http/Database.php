<?php

declare(strict_types=1);

namespace App\Php94\Installer\Http;

use Composer\Autoload\ClassLoader;
use PDO;
use PHP94\Facade\Template;
use PHP94\Help\Request;
use PHP94\Help\Response;
use Rah\Danpu\Dump;
use Rah\Danpu\Import;
use ReflectionClass;
use Throwable;

class Database extends Common
{

    public function get()
    {
        return Template::render('database@php94/installer');
    }

    public function post(
        Dump $dump,
    ) {
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        $sql_file = $root . '/config/' . (Request::post('demo') == '1' ? 'install_demo.sql' : 'install.sql');
        if (!file_exists($sql_file)) {
            return Response::error('数据库安装文件不存在，请确认是否通过官方渠道下载。');
        }
        try {
            $dump
                ->file($sql_file)
                ->dsn('mysql:dbname=' . Request::post('database_name') . ';host=' . Request::post('database_server'))
                ->user(Request::post('database_username'))
                ->pass(Request::post('database_password'))
                ->attributes([
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                ])
                ->tmp($root . '/runtime');
            new Import($dump);

            $databasetpl = <<<'str'
<?php
return [
    'master'=>[
        'database_type' => 'mysql',
        'database_name' => '{database_name}',
        'server' => '{server}',
        'username' => '{username}',
        'password' => '{password}',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'port' => '{port}',
        'logging' => false,
        'option' => [
            \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_STRINGIFY_FETCHES => false,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ],
        'command' => ['SET SQL_MODE=ANSI_QUOTES'],
    ],
];
str;

            $database_file = $root . '/config/database.php';
            if (!file_exists($database_file)) {
                if (!is_dir(dirname($database_file))) {
                    mkdir(dirname($database_file), 0755, true);
                }
            }
            file_put_contents($database_file, str_replace([
                '{server}',
                '{port}',
                '{database_name}',
                '{username}',
                '{password}',
            ], [
                Request::post('database_server'),
                Request::post('database_port'),
                Request::post('database_name'),
                Request::post('database_username'),
                Request::post('database_password'),
            ], $databasetpl));
            if (!is_dir($root . '/config/php94/installer/')) {
                mkdir($root . '/config/php94/installer/', 0755, true);
            }
            file_put_contents($root . '/config/php94/installer/disabled.lock', date('Y-m-d H:i:s'));
            return Template::render('success@php94/installer');
        } catch (Throwable $th) {
            return Response::error('发生错误：' . $th->getMessage());
        }
    }
}
