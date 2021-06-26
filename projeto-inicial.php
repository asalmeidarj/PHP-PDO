<?php

use Asalmeidarj\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Alessandro Almeida',
    new \DateTimeImmutable('1988-11-19')
);

echo $student->age();
