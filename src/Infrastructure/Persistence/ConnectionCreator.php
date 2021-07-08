<?php

/**
 * Creator Connection
 * 
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */

namespace Asalmeidarj\Pdo\Infrastructure\Persistence;

use PDO;

/**
 * Class create connection with Data Base.
 * 
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */
class ConnectionCreator
{
    /**
     * Function return PDO 
     *
     * @return PDO
     */
    public static function creatorConnection(): PDO
    {
        $pathSqlite = __DIR__ . '/../../../banco.sqlite'; 
        return new PDO('sqlite:' . $pathSqlite); 
    }
}

