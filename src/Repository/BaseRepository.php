<?php

namespace GdaeData\Repository;

use GdaeData\Environment;

/**
 * Class BaseRepository
 * @package GdaeData\Repository
 */
class BaseRepository
{
    /**
     * @var Environment
     */
    protected $env;

    /**
     * BaseRepository constructor.
     * @param Environment $env
     */
    protected function __construct(Environment $env)
    {
        $this->env = $env;
    }

    /**
     * @param string $html
     * @return int
     */
    protected function getCurrentPage(string $html): int
    {
        return (int) $this->getPagesString($html)[0][1];
    }

    /**
     * @param string $html
     * @return int
     */
    protected function getTotalPages(string $html): int
    {
        return (int) $this->getPagesString($html)[0][2];
    }

    /**
     * @param string $html
     * @return array
     */
    private function getPagesString(string $html): array
    {
        $expression = '/<span class="screen_color_PNN"> PAG\.<\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PHN">(\d*)<\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PNN"> <\/span><span class="screen_color_PNN">D<\/span><span class="screen_color_PNN">E<\/span><span class="screen_color_PNN"> <\/span><span class="screen_color_PHN"> <\/span><span class="screen_color_PHN">(\d*)<\/span>/';
        preg_match_all($expression, $html, $data, PREG_SET_ORDER);
        return $data;
    }

    /**
     * @param int $pageNumber
     */
    protected function goToPageNumber(int $pageNumber)
    {
        $this->env->post('controller.jsp', [
            'IF_1726' => $pageNumber,
            'action' => 'screen'
        ]);
    }
}