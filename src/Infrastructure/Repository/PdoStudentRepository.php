<?php

namespace Asalmeidarj\Pdo\Infrastructure\Repository;

use Asalmeidarj\Pdo\Domain\Model\Student;
use Asalmeidarj\Pdo\Domain\Repository\StudentRepository;
use Asalmeidarj\Pdo\Domain\Model\Phone;
use DateTimeImmutable;
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
            $student = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
            $this->fillPhoneOf($student);
            $studentList[] = $student;
        }
        return $studentList;
    }

    private function fillPhoneOf(Student $student): void
    {
        $sqlQuery = 'SELECT student_id, area_code, number FROM phones WHERE student_id = ?;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);
        $stmt->execute();
        while ($phoneData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $phone =  new Phone(
                $phoneData['student_id'],
                $phoneData['area_code'],
                $phoneData['number']
            );
            $student->addPhone($phone);
        }
    }

    public function insertPhone(Phone $phone): void
    {
        $sqlInsert = 'INSERT INTO phones (student_id, area_code, number) VALUES (:i, :a, :n)';
        $stmt = $this->connection->prepare($sqlInsert);
        $stmt->bindValue(':i', $phone->id(), PDO::PARAM_INT);
        $stmt->bindValue(':a', $phone->areaCode(), PDO::PARAM_STR);
        $stmt->bindValue(':n', $phone->number(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function studentWithPhone(): array
    {
        $sqlQuery = 'SELECT students.id,
                            students.name,
                            students.birth_date,
                            phones.id AS phone_id,
                            phones.area_code,
                            phones.number
                    FROM students
                    JOIN phones ON students.id = phones.student_id;';
        $stmt = $this->connection->query($sqlQuery);
        $studentList = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!array_key_exists($data['id'], $studentList)) {
                $studentList[$data['id']] = new Student(
                    $data['id'],
                    $data['name'],
                    new DateTimeImmutable($data['birth_date'])
                );
            }
            $phone = new Phone($data['phone_id'], $data['area_code'], $data['number']);
            $studentList[$data['id']]->addPhone($phone);
        }
        return $studentList;
    }
}
