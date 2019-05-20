<?php
/**
 * Created by PhpStorm.
 * User: Peggy
 * Date: 20.05.2019
 * Time: 14:40
 */

namespace App;


use Skautis\Skautis;
use Skautis\Wsdl\AuthenticationException;
use Slim\Http\Request;
use SlimSession\Helper;

/**
 * Class Authenticator
 * @package App
 */
class Authenticator
{
    /** @var Helper */
    private $session;

    /**
     * @var Skautis
     */
    private $skautis;

    /**
     * Authenticator constructor.
     *
     * @param Helper $session
     * @param Skautis $skautis
     */
    const SESSION_KEY = 'skautisUserId';

    /**
     * Authenticator constructor.
     * @param Helper $session
     * @param Skautis $skautis
     */
    public function __construct(Helper $session, Skautis $skautis)
    {
        $this->session = $session;
        $this->skautis = $skautis;
    }

    /**
     * PRihlasit aktualniho uyivatele z POST requestu
     *
     * @param Request $request
     */
    public function login(Request $request) : void
    {
        $this->skautis->setLoginData($request->getParsedBody());
        $user = $this->skautis->usr->UserDetail();

        $this->session->set(self::SESSION_KEY, [
            'id' => $user->ID,
            'userName' => $user->UserName,
            'fullName' => $user->Person,
        ]);
    }

    /**
     * Odhlasit aktualniho uzivatele
     */
    public function logout() : void
    {
        $this->session->delete(self::SESSION_KEY);
    }

    /**
     * Mame prihlaseneho uzivatele
     */
    public function isLogged() : bool
    {
        return $this->session->exists(self::SESSION_KEY);
    }

    /**
     * Vrátí jmeno přihlaseneho uzivatele
     *
     * @return string
     * @throws AuthenticationException
     */
    public function getIdentity() : string
    {
        if (!$this->isLogged())
        {
            throw new AuthenticationException('Uzivatel neni prihlaseny');
        }

        $identity = $this->session->get(self::SESSION_KEY);
        return sprintf('%s (%s)', $identity['fullName'], $identity['userName']);
    }

    /**
     * Vrati skautisUserID prihlaseneho uzivatele
     *
     * @return int
     * @throws AuthenticationException
     */
    public function getUserId() : int
    {
        if (!$this->isLogged())
        {
            throw new AuthenticationException('Uzivatel neni prihlaseny');
        }

        $identity = $this->session->get(self::SESSION_KEY);
        return $identity['id'];
    }


}