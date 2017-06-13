<?php

namespace GdaeData\Entity;

/**
 * Class Grade
 * @package GdaeData\Entity
 */
class Grade
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $period;

    /**
     * @var string
     */
    private $series;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $activeStudents;

    /**
     * Grade constructor.
     * @param string $code
     * @param string $type
     * @param string $period
     * @param string $series
     * @param string $class
     * @param string $activeStudents
     */
    public function __construct(string $code, string $type, string $period, string $series, string $class, string $activeStudents)
    {
        $this->code = $code;
        $this->type = $type;
        $this->period = $period;
        $this->series = $series;
        $this->class = $class;
        $this->activeStudents = $activeStudents;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        switch ($this->type) {
            case 3: return 'EJA ENSINO FUNDAMENTAL - ANOS INICIAIS'; break;
            case 6: return 'EDUCACAO INFANTIL'; break;
            case 14: return 'ENSINO FUNDAMENTAL DE 9 ANOS'; break;
            case 26: return 'ATIVIDADE COMPLEMENTAR'; break;
            case 32: return 'ATENDIMENTO EDUCACIONAL ESPECIALIZADO'; break;
            case 35: return 'EDUCACAO PROFISSIONAL - 10136'; break;
            default: return "TYPE-{$this->type}";
        }
    }

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        switch ($this->period) {
            case 1: return 'MANHA'; break;
            case 3: return 'TARDE'; break;
            case 4: return 'VESPERTINO'; break;
            case 5: return 'NOITE'; break;
            case 6: return 'INTEGRAL'; break;
            default: return "PERIOD-{$this->period}";
        }
    }

    /**
     * @return string
     */
    public function getSeries(): string
    {
        return $this->series;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "{$this->getType()}, {$this->getSeries()} {$this->getClass()}, {$this->getPeriod()}, {$this->getActiveStudents()} alunos";
    }

    /**
     * @return string
     */
    public function getActiveStudents()
    {
        return $this->activeStudents;
    }

}