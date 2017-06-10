<?php
/**
 * Created by PhpStorm.
 * User: monitor
 * Date: 08/06/17
 * Time: 09:35
 */

namespace GdaeData\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use GdaeData\Entity\Grade;
use GdaeData\Entity\Student;
use GdaeData\Environment;

/**
 * Class StudentsRepository
 * @package GdaeData\Repository
 */
class StudentsRepository
{
    /**
     * @var Environment
     */
    private $env;

    /**
     * StudentsRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    /**
     * @param Grade $grade
     * @return ArrayCollection
     */
    public function getAll(Grade $grade): ArrayCollection
    {
        $students = new ArrayCollection();
        return $students;
    }

}