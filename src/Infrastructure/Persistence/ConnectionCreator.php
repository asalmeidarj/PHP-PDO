<?php

namespace Asalmeidarj\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function creatorConnection(): PDO
    {
        $pathSqlite = __DIR__ . '/../../../banco.sqlite';
        $connection = new PDO('sqlite:' . $pathSqlite);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}
