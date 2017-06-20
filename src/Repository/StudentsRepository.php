<?php

namespace GdaeData\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use GdaeData\Entity\Grade;
use GdaeData\Entity\School;
use GdaeData\Entity\Student;
use GdaeData\Environment;

/**
 * Class StudentsRepository
 * @package GdaeData\Repository
 */
class StudentsRepository extends BaseRepository
{
    /**
     * StudentsRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        parent::__construct($env);
    }

    /**
     * @param School $school
     * @param Grade $grade
     * @return ArrayCollection
     */
    public function getAll(School $school, Grade $grade): ArrayCollection
    {
        $this->goToStudentsBySchoolAndGrade($school, $grade);

        $line = $this->getSanitizedLines(5, 5)[0];
        if (strpos($line, $grade->getFormattedCode()) === false) {
            return new ArrayCollection();
        }

        $students = new ArrayCollection();

        do {
            $pages = $this->getPageNavigation(22);
            $lines = $this->getSanitizedLines(11, 20);

            foreach ($lines as $line) {
                $students->add(
                    new Student(
                        trim(substr($line, 5, 2)),
                        trim(substr($line, 8, 48)),
                        trim(substr($line, 64, 9)),
                        trim(substr($line, 74, 2)),
                        trim(substr($line, 57, 3))
                    )
                );
            }

            $this->goToNextPage();

        } while ($pages['current'] < $pages['total']);

        return $students;
    }

    /**
     * @param School $school
     * @param Grade $grade
     */
    private function goToStudentsBySchoolAndGrade(School $school, Grade $grade)
    {
        $this->env->goToOption('2.2.1');
        $this->env->post([
            'IF_254' => '2017',
            'IF_363' => $school->getCode(),
            'IF_523' => $grade->getPeriod(),
            'IF_683' => $grade->getType(),
            'IF_843' => $grade->getSeries(),
            'IF_1003' => $grade->getClass(),
            'action' => 'screen'
        ]);
        $this->env->post([
            'IF_642' => 'x',
            'action' => 'screen'
        ]);
    }

}