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
    public function getAll(string $city, string $network = '2'): ArrayCollection
    {
        $this->goToSchoolsByCityAndNetwork($city, $network);

        $line = $this->getSanitizedLines(5, 5)[0];
        if (strpos($line, strtoupper($city)) === false) {
            return new ArrayCollection();
        }

        $schools = new ArrayCollection();

        do {
            $pages = $this->getPageNavigation(23);
            $lines = $this->getSanitizedLines(11, 20);

            foreach ($lines as $line) {
                $schools->add(
                    new School(
                        trim(str_replace('.', '', substr($line, 3, 7))),
                        trim(substr($line, 12, 45))
                    )
                );
            }

            $this->goToNextPage();

        } while ($pages['current'] < $pages['total']);

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
        $this->env->post([
            'IF_266' => $city,
            'IF_586' => $network,
            'IF_1146' => $status,
            'action' => 'screen'
        ]);
    }
}