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
     * Student constructor.
     * @param string $number
     * @param string $name
     * @param string $ra
     */
    public function __construct(string $number, string $name, string $ra)
    {
        $this->number = $number;
        $this->name = $name;
        $this->ra = $ra;
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
    
    
}