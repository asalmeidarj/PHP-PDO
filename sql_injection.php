<?php

/**
 * SQL Injection
 * 
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */


 use Asalmeidarj\Pdo\Domain\Model\Student;

 require_once 'vendor/autoload.php';

 ///// CONECTION
 $pathSqlite = __DIR__ . '/bancoTeste.sqlite'; 
 $pdo = new PDO('sqlite:' . $pathSqlite);
 
 echo 'Conectado...'. PHP_EOL;
 
 
 //// CREATING TABLE
$pdo->exec(
    'CREATE TABLE students (
        id INTEGER PRIMARY KEY, 
        name TEXT, 
        birth_date TEXT
        );'
);

echo "Tabela students Criada ..." . PHP_EOL;


// Creating a Student
$student = new Student(
    null, 
    'Alessandro Almeida',  
    new \DateTimeImmutable('1988-11-19')
);

echo "Aluno Alessandro criado..." . PHP_EOL;


// SQL INSERT
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (
                '{$student->name()}',
                '{$student->birthDate()->format('Y-m-d')}'
                );
            ";

$pdo->exec($sqlInsert);

echo "Aluno Alessandro inserido na tabela students ..." . PHP_EOL;


//////   SQL INJECTION
$student = new Student(
    null, 
    "nomequalquer', ''); DROP TABLE students; --",
    new \DateTimeImmutable('1988-11-19')
);

echo "Campo nome preenchido com injeção: " . $student->name() . PHP_EOL;
echo "Aluno criado com a Injeção" . PHP_EOL;


// SQL INSERT WITH SQL INJECTION    
$sqlInsert = "INSERT INTO students (name, birth_date) 
          VALUES ('{$student->name()}','{$student->birthDate()->format('Y-m-d')}');";

echo $sqlInsert . PHP_EOL;


// Inserting SQL INJECTION
$pdo->exec($sqlInsert);

echo "INJEÇÃO CONCLUIDA" . PHP_EOL;
