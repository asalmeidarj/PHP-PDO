<?php

namespace Asalmeidarj\Pdo\Domain\Repository;

use DateTimeInterface;
use Asalmeidarj\Pdo\Domain\Model\Student;

interface StudentRepository
{
    public function allStudent(): array;

    public function studentWithPhone(): array;

    public function studentBirthAt(DateTimeInterface $birthDate): array;

    public function saveStudent(Student $student): bool;

    public function remove(Student $student): bool;
}
