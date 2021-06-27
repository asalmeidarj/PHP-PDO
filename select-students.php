<?php

/**
 * Select students in Table
 * 
 * PHP version 8.0.7
 *
 * @category Sqlite
 * @package  PDO
 * @author   asalmeidarj <asalmeidarj@gmail.com>
 * @license  GPL 3.0
 * @link     https://github.com/asalmeidarj
 */

 require_once 'vendor/autoload.php';



// Connecting Data Base
$dataBasePath = __DIR__ . '/banco.sqlite'; 
$pdo = new PDO('sqlite:' . $dataBasePath);


// Select students
$statemant = $pdo->query('SELECT * FROM students;');
$listStudents = $statemant->fetchAll();

// Show Students
foreach ($listStudents as $student) {
    echo "Name: {$student['name']} => Birth Date: {$student['birth_date']}" .PHP_EOL;
}