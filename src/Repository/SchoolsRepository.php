<?php

namespace GdaeData\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use GdaeData\Entity\School;
use GdaeData\Environment;

/**
 * Class SchoolsRepository
 * @package GdaeData\Repository
 */
class SchoolsRepository extends BaseRepository
{
    /**
     * SchoolsRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        parent::__construct($env);
    }

    /**
     * @return ArrayCollection
     */
    public function getAll(): ArrayCollection
    {
        $this->goToSchoolsByCityAndNetwork('pirassununga', '2');

        $schools = new ArrayCollection();

        do {
            $html = $this->env->getCurrentScreen();

            $totalPages = $this->getTotalPages($html);
            $currentPage = $this->getCurrentPage($html);

            $expression = '/<span class="screen_color_PNN">([\s\d])<\/span><span class="screen_color_PNN">(\d{2}\.\d{3})<\/span><span class="screen_color_PNN">  <\/span><span class="screen_color_PNN">(.)<\/span><span class="screen_color_PNN">(.*)<\/span><span class="screen_color_PNN">  <\/span>/';
            preg_match_all($expression, $html, $data, PREG_SET_ORDER);

            foreach ($data as $item) {
                $schools->add(
                    new School(
                        trim($item[1]) . str_replace('.', '', $item[2]),
                        $item[3] . $item[4]
                    )
                );
            }

            if ($currentPage < $totalPages) {
                $this->goToPageNumber($currentPage + 1);
            }
        } while ($currentPage < $totalPages);

        return $schools;
    }

    /**
     * @param string $city
     * @param string $network
     * @param string $status
     */
    private function goToSchoolsByCityAndNetwork(string $city, string $network, string $status = '1')
    {
        $this->env->goToOption('2.5.5');
        $this->env->post('controller.jsp', [
            'IF_266' => $city,
            'IF_586' => $network,
            'IF_1146' => $status,
            'action' => 'screen'
        ]);
    }
}