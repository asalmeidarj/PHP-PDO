<?php

namespace Asalmeidarj\Pdo\Domain\Repository;

use DateTimeInterface;

interface StudentRepository
{
    public function allStudent(): array;

    public function studentBirthAt(DateTimeInterface $birthDate): array;

    public function saveStudent(): bool;

    public function remove(): bool;
}
