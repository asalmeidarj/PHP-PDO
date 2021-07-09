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
    "Gustavo Alburqueque",
    new \DateTimeImmutable('1988-11-19')
);

echo "Campo nome preenchido com injeção: " . $student->name() . PHP_EOL;
echo "Aluno criado com a Injeção" . PHP_EOL;


// SQL INSERT WITH SQL INJECTION    
//$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?);";
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);";

$statement = $pdo->prepare($sqlInsert);
//$statement->bindValue(1, $student->name());       
//$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));
$statement->bindValue(':name', $student->name());
$statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));


if ($statement->execute()) {
    echo "Aluno incluído!" . PHP_EOL;
}
echo $sqlInsert . PHP_EOL;

exit();


// Inserting SQL INJECTION
$pdo->exec($sqlInsert);

echo "INJEÇÃO CONCLUIDA!" . PHP_EOL;
