<?php

namespace GdaeData\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use GdaeData\Entity\Grade;
use GdaeData\Entity\School;
use GdaeData\Environment;

/**
 * Class GradesRepository
 * @package GdaeData\Repository
 */
class GradesRepository
{
    /**
     * @var Environment
     */
    private $env;

    /**
     * GradesRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    /**
     * @param School $school
     * @return ArrayCollection
     */
    public function getAll(School $school): ArrayCollection
    {
        $grades = new ArrayCollection();
        return $grades;
    }

}