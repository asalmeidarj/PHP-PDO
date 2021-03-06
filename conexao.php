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
 *
 */

$pathSqlite = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $pathSqlite);

echo 'Conectei';

//// Criando uma tabela
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY, 
        name TEXT, 
        birth_date TEXT
    );
        
    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY(student_id) REFERENCES students(id)
    );
    '
);
