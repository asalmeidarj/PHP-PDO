<?php

/**
 * Tranbalhando com Banco de dados
 * com PHP Data Object
 * 
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */


$path = __DIR__ . '/banco.sqlite'; 
$pdo = new PDO("sqlite:$path");

echo 'Conectei';