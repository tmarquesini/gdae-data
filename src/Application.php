<?php

namespace GdaeData;

use GdaeData\Repository\GradesRepository;
use GdaeData\Repository\SchoolsRepository;
use GdaeData\Repository\StudentsRepository;

/**
 * Class Application
 * @package GdaeData
 */
class Application
{
    /**
     * @var string
     */
    private $appName = 'GdaeData';

    /**
     * @var string
     */
    private $appVersion = '0.1';

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var SchoolsRepository
     */
    public $schools;

    /**
     * @var GradesRepository
     */
    public $grades;

    /**
     * @var StudentsRepository
     */
    public $students;


    /**
     * Application constructor.
     * @param string $user
     * @param string $password
     */
    public function __construct(string $user, string $password)
    {
        $this->environment = new Environment($user, $password);
        $this->schools = new SchoolsRepository($this->environment);
        $this->grades = new GradesRepository($this->environment);
        $this->students = new StudentsRepository($this->environment);
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->appName . ' ' . $this->appVersion;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->appVersion;
    }
}