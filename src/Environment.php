<?php

namespace GdaeData;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\Response;

/**
 * Class Environment
 * @package GdaeData
 */
class Environment
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Client
     */
    private $http;

    /**
     * Application constructor.
     * @param string $user
     * @param string $password
     */
    public function __construct(string $user, string $password)
    {
        $this->http = new Client([
            'base_uri' => 'https://gdaenet.edunet.sp.gov.br/Gdaenet/',
            'cookies' => new CookieJar(),
            'verify' => false
        ]);

        $this->user = $user;
        $this->password = $password;
        $this->login();
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->logout();
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $url
     * @return Response
     */
    public function get(string $url = 'controller.jsp?action=showscreen'): Response
    {
        return $this->http->request(
            'GET', $url
        );
    }

    /**
     * @param array $data
     * @param string $url
     * @return Response
     */
    public function post(array $data, string $url = 'controller.jsp'): Response
    {
        return $this->http->request(
            'POST', $url, [
                'form_params' => $data
            ]
        );
    }

    /**
     *
     */
    private function login()
    {
        $data = [
            'user' => $this->user,
            'senha' => $this->password,
            'transacao' => 'jcaa'
        ];
        $this->post($data, 'index.jsp');

        $html = $this->get()->getBody()->getContents();

        $pattern = '/<p id="labelErro">ERRO:<\/p>\s*<p id="outErro">(.*)<\/p>/';
        if (preg_match($pattern, $html, $error)) {
            throw new \Exception($error[1]);
        }
    }

    /**
     *
     */
    private function logout()
    {
        $this->get('controller.jsp?action=disconnect');
    }

    /**
     *
     */
    private function goToMainMenu()
    {
        $data = [
            'AK_364' => true,
            'action' => 'screen'
        ];
        $this->post($data);
    }

    /**
     * @param $option
     */
    public function goToOption(string $option)
    {
        $this->goToMainMenu();
        $data = [
            'AT_inOpcaoJCAA' => $option,
            'action' => 'entity',
            'entity' => 'MenuPrincipalJCAA'
        ];
        $this->post($data);
    }

    /**
     * @return bool|string
     */
    public function getCurrentScreen()
    {
        return $this->get()->getBody()->getContents();
    }

}