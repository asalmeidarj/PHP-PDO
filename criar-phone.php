<?php

use Asalmeidarj\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Asalmeidarj\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Asalmeidarj\Pdo\Domain\Model\Phone;

require_once './vendor/autoload.php';

$connection = ConnectionCreator::creatorConnection();
$pdo = new PdoStudentRepository($connection);

$connection->beginTransaction();

$phone = new Phone(6, '22', '99881-1981');
$phone2 = new Phone(6, '22', '99817-4220');

$pdo->insertPhone($phone);
$pdo->insertPhone($phone2);

$studentList = $pdo->allStudent();
foreach ($studentList as $student) {
    if ($student->phones() != null) {
        $phones = $student->phones();
        echo "Student: {$student->name()}" . PHP_EOL;
        $i = 1;
        foreach ($phones as $phone) {
            echo "Phone($i): {$phone->formattedPhone()}";
            $i++;
        }
    }
}

$connection->rollBack();
