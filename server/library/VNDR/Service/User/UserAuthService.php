<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 24/11/14
 * Time: 18:35
 */

//http://www.php-fig.org/psr/psr-0/
namespace VNDR\Service\User;

use ART\Debug;
use ART\Hash\Password;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use ART\Ws\Adapter\JsonRPC\JsonRPCError;
use VNDR\Logic\User\Auth\UserAuth;
use VNDR\Logic\User\Auth\UserToken;
use VNDR\Logic\User\UserManager;
use VNDR\Model\UserVisitorModelModel;
use VNDR\Service\Service;
use VNDR\Service\ServiceWithoutToken;

class UserAuthService extends ServiceWithoutToken
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login user with username and password
     *
     * @param $email
     * @param $password
     * @return array
     */
    public function login($email, $password)
    {
        $user_manager = new UserManager();
        return $user_manager->login($email, $password);
    }

    /**
     * Logout
     */
    public function logout()
    {

    }

    /**
     * Get user by token
     *
     * @param $token
     * @return \VNDR\Model\UserModel
     */
    public function getUserByToken($token) {
        $user_manager = new UserManager();
        return $user_manager->getUserByToken($token);
    }
} 