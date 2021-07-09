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


// Connection
$pdo = \Asalmeidarj\Pdo\Infrastructure\Persistence\ConnectionCreator::creatorConnection();


// Creating a Student
$student = new Student(
    null,
    'Ricardão da Esquina',
    new \DateTimeImmutable('1988-11-19')
);

// SQL INSERT
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (
                :name,
                :birth_date
                );
            ";

$name = $student->name();
$birth_date = $student->birthDate()->format('Y-m-d');
echo $birth_date . PHP_EOL;

$prepareStatement = $pdo->prepare($sqlInsert);
$prepareStatement->bindValue(':name', $name, PDO::PARAM_STR);
$prepareStatement->bindValue(':birth_date', $birth_date, PDO::PARAM_STR);

if ($prepareStatement->execute()) {
    echo "Student $name include!" . PHP_EOL;
}
