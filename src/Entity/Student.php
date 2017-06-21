<?php

namespace GdaeData\Entity;

/**
 * Class Student
 * @package GdaeData\Entity
 */
class Student
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $ra;

    /**
     * @var string
     */
    private $digit;

    /**
     * @var string
     */
    private $status;

    /**
     * Student constructor.
     * @param string $number
     * @param string $name
     * @param string $ra
     * @param string $status
     * @param string $digit
     */
    public function __construct(string $number, string $name, string $ra, string $digit, string $status)
    {
        $this->number = $number;
        $this->name = $name;
        $this->ra = $ra;
        $this->digit = $digit;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRa(): string
    {
        return $this->ra;
    }

    /**
     * @return string
     */
    public function getDigit(): string
    {
        return $this->digit;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}