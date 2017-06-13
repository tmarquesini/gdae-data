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
     * @param Grade $grade
     * @return ArrayCollection
     */
    public function getAll(School $school, Grade $grade): ArrayCollection
    {
        $this->goToStudentsBySchoolAndGrade($school, $grade);

        $students = new ArrayCollection();

        do {
            $html = $this->env->getCurrentScreen();

            $totalPages = $this->getTotalPages($html);
            $currentPage = $this->getCurrentPage($html);

            $pattern = '/<span class="screen_color_PNN">.*\s{2}\d{9}\s[\dX]\s{2}.{2}<\/span>/';
            preg_match_all($pattern, $html, $data, PREG_SET_ORDER);

            foreach ($data as $item) {
                $pattern = '/<[^>]*>/';
                $line = preg_replace($pattern, '', $item[0]);
                $status = trim(substr($line, 57, 3));
                if ($status == '') {
                    $students->add(
                        new Student(
                            trim(substr($line, 5, 2)),
                            trim(substr($line, 8, 48)),
                            str_replace(' ', '', substr($line, 64, 11))
                        )
                    );
                }
            }

            if ($currentPage < $totalPages) {
                $this->goToPageNumber($currentPage + 1);
            }
        } while ($currentPage < $totalPages);

        return $students;
    }

    /**
     * @param School $school
     * @param Grade $grade
     */
    private function goToStudentsBySchoolAndGrade(School $school, Grade $grade)
    {
        $this->env->goToOption('2.2.1');
        $this->env->post('controller.jsp', [
            'IF_254' => '2017',
            'IF_363' => $school->getCode(),
            'IF_523' => $grade->getPeriod(),
            'IF_683' => $grade->getType(),
            'IF_843' => $grade->getSeries(),
            'IF_1003' => $grade->getClass(),
            'action' => 'screen'
        ]);
        $this->env->post('controller.jsp', [
            'IF_642' => 'x',
            'action' => 'screen'
        ]);
    }

}