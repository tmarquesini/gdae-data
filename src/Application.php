<?php

namespace GdaeData;

use GdaeData\Repository\SchoolsRepository;

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
     * TODO: Change access to private
     * @var Environment
     */
    public $environment;

    /**
     * @var SchoolsRepository
     */
    public $schools;


    /**
     * Application constructor.
     * @param string $user
     * @param string $password
     */
    public function __construct(string $user, string $password)
    {
        $this->environment = new Environment($user, $password);
        $this->schools = new SchoolsRepository($this->environment);
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