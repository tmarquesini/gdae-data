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
class GradesRepository extends BaseRepository
{
    /**
     * GradesRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        parent::__construct($env);
    }

    /**
     * @param School $school
     * @return ArrayCollection
     */
    public function getAll(School $school): ArrayCollection
    {
        $this->goToGradesBySchool($school);

        // TODO Adicionar verificação se foram encontradas classes

        $grades = new ArrayCollection();

        do {
            $pages = $this->getPageNavigation(23);
            $lines = $this->getSanitizedLines(10, 20);

            foreach ($lines as $line) {
                $grades->add(
                    new Grade(
                        trim(str_replace('.', '', substr($line, 68, 11))),
                        trim(substr($line, 7, 2)),
                        trim(substr($line, 2, 2)),
                        trim(substr($line, 18, 2)),
                        trim(substr($line, 21, 2)),
                        trim(substr($line, 59, 2))
                    )
                );
            }

            $this->goToNextPage();

        } while ($pages['current'] < $pages['total']);

        return $grades;
    }

    /**
     * @param School $school
     */
    private function goToGradesBySchool(School $school)
    {
        $this->env->goToOption('2.2.1');
        $this->env->post([
            'IF_363' => $school->getCode(),
            'action' => 'screen'
        ]);
    }
}