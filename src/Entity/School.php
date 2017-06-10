<?php

namespace GdaeData\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class School
 * @package GdaeData\Entity
 */
class School
{
    /**
     * @var
     */
    private $code;

    /**
     * @var
     */
    private $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

}