<?php

namespace Asalmeidarj\Pdo\Infrastructure\Repository;

use Asalmeidarj\Pdo\Domain\Model\Student;
use Asalmeidarj\Pdo\Domain\Repository\StudentRepository;
use DateTimeInterface;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudent(): array
    {
        // Select all students
        $stm = $this->connection->query('SELECT * FROM students;');

        return $this->hidrateStudentList($stm);
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array
    {
        $stm = $this->connection->prepare('SELECT * FROM students WHERE birth_date = ?;');
        $stm->bindValue(1, $birthDate->format('Y-m-d'), PDO::PARAM_STR);    
        $stm->execute();

        return $this->hidrateStudentList($stm);
    }

    public function saveStudent(): bool
    {
        return false;
    }

    public function remove(): bool
    {
        return false;
    }

    private function hidrateStudentList(\PDOStatement $stm): array
    {
        $studentList = [];

        while ($studentData = $stm->fetch(PDO::FETCH_ASSOC)) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
        }
        return $studentList;
    }
}
