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

    public function saveStudent(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $stmt = $this->connection->prepare($insertQuery);

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $removeSql = 'DELETE FROM students WHERE id = ?';
        $stm = $this->connection->prepare($removeSql);
        $stm->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stm->execute();
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
