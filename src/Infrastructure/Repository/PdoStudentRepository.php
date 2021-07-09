<?php

namespace Asalmeidarj\Pdo\Infrastructure\Repository;

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
        $allStudent = [];

        // Select all students
        $statement = $this->connection->query('SELECT * FROM students;');

        // Get Students
        while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $allStudent[] = [
                'id' => $studentData['id'],
                'name' => $studentData['name'],
                'birthDate' => $studentData['birth_date']
            ];
        }
        return $allStudent;
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array
    {
        return [];
    }

    public function saveStudent(): bool
    {
        return false;
    }

    public function remove(): bool
    {
        return false;
    }
}
