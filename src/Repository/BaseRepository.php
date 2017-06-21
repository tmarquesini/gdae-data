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
     * @param int $lineNumber
     * @return array
     */
    protected function getPageNavigation(int $lineNumber): array
    {
        $html = $this->env->getCurrentScreen();

        $pattern = '/((\r?\n)|(\r\n?))/';
        $lines = preg_split($pattern, $html);

        $pattern = '/<[^>]*>/';
        $sanitizedPagesLine = preg_replace($pattern, '', $lines[$lineNumber]);

        $pagesNavigation= [
            'current' => (int) trim(substr($sanitizedPagesLine, 6, 2)),
            'total' => (int) trim(substr($sanitizedPagesLine, 12, 2))
        ];

        return $pagesNavigation;
    }

    /**
     *
     */
    protected function goToNextPage()
    {
        $this->env->post([
            'action' => 'screen'
        ]);
    }

    /**
     * @param int $startLineNumber
     * @param int $endLineNumber
     * @return array
     */
    protected function getSanitizedLines(int $startLineNumber, int $endLineNumber): array
    {
        $html = $this->env->getCurrentScreen();

        $pattern = '/((\r?\n)|(\r\n?))/';
        $lines = preg_split($pattern, $html);

        $sanitizedScreen = [];
        $pattern = '/<[^>]*>/';
        for ($i = $startLineNumber; $i <= $endLineNumber; $i++) {
            $line = preg_replace($pattern, '', $lines[$i]);
            if (trim($line) != '') {
                $sanitizedScreen[] = $line;
            }
        }

        return $sanitizedScreen;
    }
}