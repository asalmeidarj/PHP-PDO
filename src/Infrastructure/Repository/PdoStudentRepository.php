<?php

namespace Asalmeidarj\Pdo\Infrastructure\Repository;

use Asalmeidarj\Pdo\Domain\Repository\StudentRepository;
use Asalmeidarj\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeInterface;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectionCreator::creatorConnection();
    }

    public function allStudent(): array
    {
        $allStudent = [];

        // Select all students
        $statement = $this->pdo->query('SELECT * FROM students;');

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
