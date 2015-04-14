<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 11. 27.
 * Time: 19:03
 */

namespace VNDR\Logic\User;


use VNDR\Logic\User\Auth\UserAuth;
use VNDR\Logic\User\Auth\UserToken;
use VNDR\Logic\User\Profile\UserProfile;
use VNDR\Model\UserModel;

class UserManager {

    /**
     * Construct of the Usermanager
     */
    public function __construct()
    {

    }

    /**
     * Get user by id
     *
     * @param $user_id
     * @param bool $only_active
     * @return UserModel
     */
    public function getUserById($user_id, $only_active = false)
    {
        if ($only_active) {
            $where = sprintf("id = %d AND active = 1", $user_id);
        } else {
            $where = sprintf("id = %d", $user_id);
        }

        $user = UserModel::findFirst($where);

        if ($user) {
            return $user;
        }
    }

    /**
     * Get user by token
     *
     * @param $token
     * @return UserModel
     * @throws \ART\Ws\Adapter\JsonRPC\JsonRPCException
     */
    public function getUserByToken($token)
    {
        $user_auth = new UserAuth();
        return $user_auth->getUserByToken($token);
    }


    /**
     * Login user with email and password
     *
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        $user_auth = new UserAuth();
        return $user_auth->login($email, $password);
    }


    /**
     * Logout
     */
    public function logout()
    {

    }

    /**
     * Get profile by user id
     *
     * @param $user_id
     * @return array
     */
    public function getProfileByUserId($user_id)
    {
        $user_profile = new UserProfile();
        return $user_profile->getProfileByUserId($user_id);
    }

    /**
     * Get a company's users by company id
     *
     * @param $company_id
     * @return array
     */
    public function getUsersByCompanyId($company_id = NULL)
    {
        $data = new UserProfile();
        return $data->getUsersByCompanyId($company_id);
    }

    public function addUser($user_data)
    {
        $data = new UserProfile();
        return $data->addUser($user_data);
    }

    public function saveProfile($user_profile)
    {
        $data = new UserProfile();
        return $data->saveProfile($user_profile);
    }

}