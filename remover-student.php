<?php

/**
 * Remove students in Table
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */

require_once 'vendor/autoload.php';

$pdo = \Asalmeidarj\Pdo\Infrastructure\Persistence\ConnectionCreator::creatorConnection();


$sqlDelete = "DELETE FROM students WHERE name = ?;";
$prepareStatement = $pdo->prepare($sqlDelete);
$nome = 'Alessandro Almeida';
$prepareStatement->bindValue(1, $nome, PDO::PARAM_STR);

if ($prepareStatement->execute()) {
    echo 'Aluno Removido';
}
