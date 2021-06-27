<?php

/**
 * Insert students in Table
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



// Connecting Data Base
$dataBasePath = __DIR__ . '/banco.sqlite'; 
$pdo = new PDO('sqlite:' . $dataBasePath);


// Creating a Student
$student = new Student(
    null, 
    'Alessandro Almeida',  
    new \DateTimeImmutable('1988-11-19')
);

// SQL INSERT
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (
                '{$student->name()}',
                '{$student->birthDate()->format('Y-m-d')}'
                );
            ";
 
echo $sqlInsert;

$pdo->exec($sqlInsert);