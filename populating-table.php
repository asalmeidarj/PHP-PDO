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



/**
 * Insert the students into the table
 * with a array of students.
 *
 * @param array $students contains Key=name type string and 
 *                        Value=birth_date type string
 * @param PDO   $pdo      PHP Data Object
 * 
 * @return void
 */
function insertStudents(array $students, PDO $pdo): void 
{
    $sqlInsert='';
    foreach ($students as $name=>$birth) {
        $student = new Student(
            null, 
            "$name",  
            new \DateTimeImmutable("$birth")
        );
        $sqlInsert .= "INSERT INTO students (name, birth_date) VALUES (
            '{$student->name()}',
            '{$student->birthDate()->format('Y-m-d')}'
            );
        " . PHP_EOL;        
    }
    //running sql
    $pdo->exec($sqlInsert);
}


// Creating the Students into the Array
$students = [
    'Alessandro Almeida' => '1988-11-19',
    'Gisele Almeida' => '1988-04-06',
    'Giovana Almeida' => '2007-12-08',
    'Clara Almeida' => '2009-02-22'
];


insertStudents($students, $pdo);