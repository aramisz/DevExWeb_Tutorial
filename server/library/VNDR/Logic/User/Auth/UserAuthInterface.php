<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 04.
 * Time: 18:23
 */

namespace VNDR\Logic\User\Auth;


interface UserAuthInterface {

    /**
     * Login user with $email and $password
     *
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password);

    /**
     * Logout user
     *
     * @return mixed
     */
    public function logout();
}