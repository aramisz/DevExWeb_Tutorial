<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 11. 27.
 * Time: 17:32
 */

namespace VNDR\Service;

use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use Phalcon\Debug;
use Phalcon\Exception;
use Phalcon\Http\Request;
use VNDR\Logic\User\UserManager;

class ServiceWithToken extends Service {

    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->checkToken();
    }

    /**
     * Get User
     * @return \VNDR\Model\UserModel
     * @throws JsonRPCException
     */
    public function checkToken()
    {
        $user_manager = new UserManager();
        try {
            $user = $user_manager->getUserByToken($this->getToken());

            if ($user) {
                $this->user = $user;
            } else {
               throw new JsonRPCException("You are not authorized!");
            }

        } catch (JsonRPCException $e) {
            header('HTTP/1.0 403 Forbidden');
            throw new JsonRPCException($e->getMessage());
        }

    }

    /**
     * Get User
     *
     * @return \VNDR\Model\UserModel
     */
    public function getUser()
    {
        return $this->user;
    }

} 