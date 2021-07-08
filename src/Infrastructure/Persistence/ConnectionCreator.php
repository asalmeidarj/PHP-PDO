<?php

namespace Asalmeidarj\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function creatorConnection(): PDO
    {
        $pathSqlite = __DIR__ . '/../../../banco.sqlite';
        return new PDO('sqlite:' . $pathSqlite);
    }
}
