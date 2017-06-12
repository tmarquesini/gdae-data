<?php

namespace GdaeData\Entity;

/**
 * Class Grade
 * @package GdaeData\Entity
 */
class Grade
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $series;

    /**
     * @var string
     */
    private $class;

    /**
     * Grade constructor.
     * @param string $code
     * @param string $series
     * @param string $class
     */
    public function __construct(string $code, string $series, string $class)
    {
        $this->code = $code;
        $this->series = $series;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSeries(): string
    {
        return $this->series;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getFullGradeName(): string
    {
        return $this->getSeries().'º'.$this->getClass();
    }

}