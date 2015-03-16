<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 05.
 * Time: 13:36
 */

namespace VNDR\Service\User;


use ART\Debug;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use VNDR\Logic\User\UserManager;
use VNDR\Service\ServiceWithToken;

class UserService extends ServiceWithToken
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserProfile()
    {
        $user_manager = new UserManager();
        $data = $user_manager->getProfileByUserId($this->getUser()->getId());

        Debug::file($data, "UserProfile");

        if ($data)
        {
            return $data;
//            $this->response->setOutcome(true);
//            $this->response->setData($data);
//            $this->response->setMessage("");
//            return $this->response->toArray();
        }
    }

    public function getUsersByCompanyId($company_id = NULL)
    {
        $user_manager = new UserManager();

        return $user_manager->getUsersByCompanyId($company_id);

    }

    public function addUser($user_data)
    {
        $user_manager = new UserManager();

        $outcome = $user_manager->addUser($user_data);

        $this->response->setOutcome($outcome ? true : false);
        $this->response->setMessage($outcome ? 'success' : 'fail');

        return $this->response->toArray();

    }

    public function saveProfile($user_profile)
    {
        $user_manager = new UserManager();

        $outcome = $user_manager->saveProfile($user_profile);

        $this->response->setOutcome($outcome ? true : false);
        $this->response->setMessage($outcome ? 'success' : 'fail');
        $this->response->setData($outcome ? $outcome : array());

        return $this->response->toArray();

    }
}