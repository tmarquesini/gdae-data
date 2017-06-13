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

        $grades = new ArrayCollection();

        do {
            $html = $this->env->getCurrentScreen();

            $totalPages = $this->getTotalPages($html);
            $currentPage = $this->getCurrentPage($html);

            $pattern = '/\n<span class="screen_color_PNN">.*\d{2}\.\d{3}\.\d{3}<\/span>/';
            preg_match_all($pattern, $html, $data, PREG_SET_ORDER);

            foreach ($data as $item) {
                $pattern = '/<[^>]*>/';
                $line = preg_replace($pattern, '', $item[0]);
                $grades->add(
                    new Grade(
                        substr($line, 69, 11),
                        trim(substr($line, 8, 2)),
                        trim(substr($line, 3, 2)),
                        trim(substr($line, 19, 2)),
                        trim(substr($line, 22, 2)),
                        trim(substr($line, 60, 2))
                    )
                );
            }

            if ($currentPage < $totalPages) {
                $this->goToPageNumber($currentPage + 1);
            }
        } while ($currentPage < $totalPages);

        return $grades;
    }

    /**
     * @param School $school
     */
    private function goToGradesBySchool(School $school)
    {
        $this->env->goToOption('2.2.1');
        $this->env->post('controller.jsp', [
            'IF_363' => $school->getCode(),
            'action' => 'screen'
        ]);
    }
}