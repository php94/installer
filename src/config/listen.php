<?php

use App\Php94\Installer\Middleware\InstallerMiddleware;
use PHP94\Handler\Handler;

return [
    Handler::class => function (
        Handler $handler
    ) {
        $handler->pushMiddleware(InstallerMiddleware::class);
    },
];
