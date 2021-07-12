<?php

namespace Asalmeidarj\Pdo\Domain\Model;

class Phone
{
    private ?int $id;
    private string $area_code;
    private string $number;
    //private Student $student;

    public function __construct(?int $id, string $area_code, string $number)
    {
        $this->id = $id;
        $this->area_code = $area_code;
        $this->number = $number;
    }
}
