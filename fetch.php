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
$statement = $pdo->query('SELECT * FROM students;');

// Show Students
while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    echo $studentData['name'] . PHP_EOL;
}

/*
    NOTE: Removing 'WHERE id = 3' from the query method,
          it would display all the names in the table.
          When we pass the return value of the 'fetch' method
          inside a WHILE an iteration occurs.

            Exemplo:

              $statement = $pdo->query('SELECT * FROM students;');

              while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
                  echo $studentData['name'] . PHP_EOL;
              }
*/
