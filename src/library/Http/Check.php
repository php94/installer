<?php

declare(strict_types=1);

namespace App\Php94\Installer\Http;

use Composer\Autoload\ClassLoader;
use PHP94\Config;
use PHP94\Template;
use ReflectionClass;

class Check extends Common
{
    public function get()
    {
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        $env_err = false;

        $envs = $this->checkEnv($env_err);

        $dirfile = $this->checkDirfile(Config::get('check.dirfile@php94/installer', [
            ['dir', $root . '/runtime', '可写', true],
            ['file', $root . '/config/database.php', '可写', true],
        ]), $env_err);

        $func = $this->checkFunc(Config::get('check.func@php94/installer', [
            ['pdo', '支持', true, '类'],
            ['pdo_mysql', '支持', true, '模块'],
            ['mb_strlen', '支持', true, '函数'],
        ]), $env_err);

        return Template::render('check@php94/installer', [
            'envs' => $envs,
            'dirfile' => $dirfile,
            'func' => $func,
            'env_err' => $env_err,
        ]);
    }

    private function checkEnv(&$env_err)
    {
        $items = [
            'os' => ['操作系统', '不限制', '类Unix', PHP_OS, true],
            'php' => ['PHP版本', '8.0', '8.0+', PHP_VERSION, true],
            'disk' => ['磁盘空间', '100M', '不限制', '未知', true],
        ];

        //PHP环境检测
        if ($items['php'][3] < $items['php'][1]) {
            $items['php'][4] = false;
            $env_err = true;
        }

        //磁盘空间检测
        if (function_exists('disk_free_space')) {
            $items['disk'][3] = floor(disk_free_space(realpath('./') . DIRECTORY_SEPARATOR) / (1024 * 1024)) . 'M';
        }
        return $items;
    }

    private function checkDir(string $dir): bool
    {
        return is_dir($dir) ? is_writable($dir) : $this->checkDir(dirname($dir));
    }

    /**
     * 目录，文件读写检测
     * @return array 检测数据
     */
    private function checkDirfile(array $items, &$env_err)
    {
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        foreach ($items as &$val) {
            if ('dir' == $val[0]) {
                if (!is_dir($val[1]) || !is_writable($val[1])) {
                    $val[2] = '不存在或不可写';
                    $val[3] = false;
                    $env_err = true;
                }
            } else {
                if (!file_exists($val[1])) {
                    if (!$this->checkDir(dirname($val[1]))) {
                        $val[2] = '不可写';
                        $val[3] = false;
                        $env_err = true;
                    }
                } else {
                    if (!is_writable($val[1])) {
                        $val[2] = '不可写';
                        $val[3] = false;
                        $env_err = true;
                    }
                }
            }
            $val[1] = str_replace($root, '', $val[1]);
        }
        return $items;
    }

    /**
     * 函数检测
     * @return array 检测数据
     */
    private function checkFunc(array $items, &$env_err)
    {
        foreach ($items as &$val) {
            if (
                ('类' == $val[3] && !class_exists($val[0]))
                || ('模块' == $val[3] && !extension_loaded($val[0]))
                || ('函数' == $val[3] && !function_exists($val[0]))
            ) {
                $val[1] = '不支持';
                $val[2] = 'error';
                $env_err = true;
            }
        }
        return $items;
    }
}
