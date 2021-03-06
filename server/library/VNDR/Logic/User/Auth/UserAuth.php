<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 04.
 * Time: 18:06
 */

namespace VNDR\Logic\User\Auth;

use ART\Debug;
use ART\Hash\Password;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use VNDR\Model\UserModel;
use VNDR\Model\UserTokenModel;
use VNDR\Service\ServiceWithoutToken;

class UserAuth extends ServiceWithoutToken
{
    /**
     * Login user with $email, $password and $user_type
     *
     * @param $email
     * @param $password
     * @return array
     * @throws JsonRPCException
     */
    public function login($email, $password)
    {
        $where = sprintf("email = '%s' AND password = '%s'", $email, Password::encodePassword($email, $password));

        /** @var UserModel $user */
        $user = UserModel::findFirst($where);


        if ($user) {

            if (!$user->getActive()) {
                throw new JsonRPCException("You are not activated!");
            }

            //Debug::file($user->toArray());
            $user_id = $user->id;
            $client_agent = $_SERVER["HTTP_USER_AGENT"];
            $token = UserToken::generateToken();

            $user_token = new UserTokenModel();
            $user_token->setUserId($user_id);
            $user_token->setToken($token);
            $user_token->setExpiration(date("Y-m-d H:i:s", time() + TOKEN_EXPIRATION));
            $user_token->setClientAgent($client_agent);
            $user_token->saveToken();

            $user_data = $user->toArray();
            unset($user_data["password"]);

            return array(
                "success" => true,
                "user" => $user_data,
                "token" => $token
            );
        } else {
            header('HTTP/1.0 402 Forbidden');
            throw new JsonRPCException("Wrong email or password!");
        }

    }

    public function logout()
    {

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
        try {
            $user_data = UserToken::getUserByToken($token);

            return array(
                "success" => true,
                "user" => $user_data,
                "token" => $token
            );
        } catch (JsonRPCException $e) {
            header('HTTP/1.0 403 Forbidden');
            throw new JsonRPCException("Invalid token!");
        }

    }
} 