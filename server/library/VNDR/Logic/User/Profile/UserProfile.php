<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 05.
 * Time: 13:38
 */

namespace VNDR\Logic\User\Profile;


use ART\Debug;
use ART\Hash\Password;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use VNDR\Model\CompanyModel;
use VNDR\Model\UserModel;
use VNDR\Model\UserProfileModel;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use VNDR\Service\Exception;

class UserProfile
{
    public $user;
    public $profile;
    public $company;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get profile by user id
     *
     * @param $user_id
     * @return array
     */
    public function getProfileByUserId($user_id)
    {
        $where = sprintf("id = %d", $user_id);

        /** @var UserModel $user */
        $user = UserModel::findFirst($where);

        if ($user)
        {
            $user->setActive($user->getActive() ? true : false);
            $this->setUser($user->toArray());

            $where = sprintf("user_id = %d", $user->getId());
            /** @var UserProfileModel $profile */
            $profile = UserProfileModel::findFirst($where);

            if ($profile)
            {
                $this->setProfile($profile->toArray());

                $where = sprintf("id = %d", $profile->getCompanyId());
                $company = CompanyModel::findFirst($where);

                if ($company)
                {
                    $this->setCompany($company->toArray());
                }
            }

            return $this->toArray();
        }
    }

    /**
     * Get a company's users by company id
     *
     * @param $company_id
     * @return array
     */
    public function getUsersByCompanyId($company_id = NULL)
    {
        $where = sprintf("id = %d", $company_id);
        $where = array();

        /** @var UserModel $user */
        $data = UserModel::find();

        $array = array();

        /** @var UserModel $row */
        foreach ($data as $row)
        {
            $array[] = $this->getProfileByUserId($row->getId());
        }

        return $array;

    }

    public function addUser($user_data)
    {

        try
        {
            $txManager = new TxManager();
            $transaction = $txManager->get();

            $user_model = new UserModel();
            $user_model->setTransaction($transaction);

            $user_model->setRoleId($user_data['role_id']);
            $user_model->setEmail($user_data['email']);
            $user_model->setActive($user_data['active']);

            $password = $this->generatePassword($user_data['firstname'], $user_data['lastname']);

            if (!$password)
            {
                $transaction->rollback("Can't generate password!");
            }
            else
            {
                $user_model->setPassword(Password::encodePassword($user_model->getEmail(), $password));

                if ($user_model->save() == false)
                {
                    $transaction->rollback("Can't save user!");

                }
                else
                {
                    $profile_model = new UserProfileModel();
                    $profile_model->setTransaction($transaction);

                    $profile_model->setUserId($user_model->getId());
                    $profile_model->setFirstname($user_data['firstname']);
                    $profile_model->setLastname($user_data['lastname']);
                    $profile_model->setCompanyId($user_data['company_id']);

                    if ($profile_model->save() == false)
                    {
                        $transaction->rollback("Can't save profile!");

                    }

                }

            }

            $transaction->commit();

        } catch (TxFailed $e)
        {
//            $transaction->rollback();

            throw new JsonRPCException($e->getMessage());

        }

        return true;

    }

    public function saveProfile($user_profile)
    {
//        Debug::file($user_profile, "UserProfile");
        $where = sprintf("id = %d", $user_profile['profile']['id']);

        /** @var UserModel $user */
        $profile_model = UserProfileModel::findFirst($where);

        $profile_model->setFirstname($user_profile['profile']['firstname']);
        $profile_model->setLastname(($user_profile['profile']['lastname']));
        $profile_model->setTitle($user_profile['profile']['title']);

        $outcome = $profile_model->save();

        Debug::file($outcome, "saveProfile");


        return $outcome ? $profile_model->toArray() : $outcome;

    }

    private function generatePassword($firstname, $lastname)
    {
        $firstname = strtolower(trim($firstname));
        $lastname = strtolower(trim($lastname));

        return ($firstname and $lastname) ? ($firstname[0] . $lastname) : false;
    }

    /**
     * Return object to array
     *
     * @return array
     */
    public
    function toArray()
    {
        return array(
            "user" => $this->getUser(),
            "profile" => $this->getProfile(),
            "company" => $this->getCompany()
        );
    }

}