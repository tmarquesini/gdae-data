<?php

namespace GdaeData\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use GdaeData\Entity\School;
use GdaeData\Environment;

/**
 * Class SchoolsRepository
 * @package GdaeData\Repository
 */
class SchoolsRepository
{
    /**
     * @var Environment
     */
    private $env;

    /**
     * SchoolsRepository constructor.
     * @param Environment $env
     */
    public function __construct(Environment $env)
    {
        $this->env = $env;
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

            $totalPages = $this->getTotalPages($html); die($totalPages);
            $currentPage = $this->getCurrentPage($html);

            $expression = '<span class="screen_color_PNN">[\s\d]<\/span><span class="screen_color_PNN">\d{2}\.\d{3}<\/span><span class="screen_color_PNN">  <\/span><span class="screen_color_PNN">.<\/span><span class="screen_color_PNN">.*<\/span>';
            preg_match_all($expression, $html, $data);

            foreach ($data as $item) {
                $schools->add(new School($item[1] . $item[2], $item[3] . $item[4]));
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

    /**
     * @param string $html
     * @return int
     */
    private function getCurrentPage(string $html): int
    {
        return (int) $this->getPagesString($html)[1];
    }

    /**
     * @param string $html
     * @return int
     */
    private function getTotalPages(string $html): int
    {
        return (int) $this->getPagesString($html)[2];
    }

    private function getPagesString(string $html): array
    {
        $expression = '/<span class="screen_color_PNN"> PAG\.<\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PHN">(\d*)<\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PNN"> <\/span><span class="screen_color_PNN">D<\/span><span class="screen_color_PNN">E<\/span><span class="screen_color_PNN"> <\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PHN">(\d*)<\/span>/';
        preg_match_all($expression, $html, $data);
        return $data;
    }

    /**
     * @param int $pageNumber
     */
    private function goToPageNumber(integer $pageNumber)
    {
        $this->env->post('controller.jsp', [
            'IF_1726' => $pageNumber,
            'action' => 'screen'
        ]);
    }

}