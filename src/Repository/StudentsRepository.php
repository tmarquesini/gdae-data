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
     * @param Grade $grade
     * @return ArrayCollection
     */
    public function getAll(Grade $grade): ArrayCollection
    {
        $this->goToGradesBySchool($grade);

        $students = new ArrayCollection();

        do {
            $html = $this->env->getCurrentScreen();

            $totalPages = $this->getTotalPages($html);
            $currentPage = $this->getCurrentPage($html);

            $expression = '//';
            preg_match_all($expression, $html, $data, PREG_SET_ORDER);

            foreach ($data as $item) {
                $students->add(
                    new Student(
                        'number',
                        'name',
                        'ra'
                    )
                );
            }

            if ($currentPage < $totalPages) {
                $this->goToPageNumber($currentPage + 1);
            }
        } while ($currentPage < $totalPages);

        return $students;
    }

}