<?php

use Asalmeidarj\Pdo\Domain\Model\Student;
use Asalmeidarj\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Asalmeidarj\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once './vendor/autoload.php';

///// Criando Conexão com o Banco de Dandos //////////



$connection = ConnectionCreator::creatorConnection();
$pdo = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {
    $student1 = new Student(
        null,
        'Almir Almeida',
        new DateTimeImmutable('1960-08-08')
    );

    $student2 = new Student(
        null,
        'Daniel Louro Costa',
        new DateTimeImmutable('1983-10-24')
    );

    $pdo->saveStudent($student1);
    $pdo->saveStudent($student2);

    $studentList = $pdo->allStudent();

    foreach ($studentList as $student) {
        echo "Id: {$student->id()} Nome: {$student->name()} Idade: {$student->age()}" . PHP_EOL;
    }
    echo 'Ocorreu tudo bem!' . PHP_EOL;
    $connection->rollBack();
} catch (\PDOException $e) {
    echo $e->getMessage();
    echo PHP_EOL . 'CORRIGIR ERRO' . PHP_EOL;
    $connection->rollBack();
}
