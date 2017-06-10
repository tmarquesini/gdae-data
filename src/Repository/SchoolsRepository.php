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
        print_r($this->env->getCurrentScreen());
        die;
        return new ArrayCollection();
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