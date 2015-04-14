<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 01. 31.
 * Time: 21:25
 */

namespace VNDR\Logic\User\Auth;


use ART\Debug;
use ART\JWT\JWT;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use VNDR\Logic\User\UserManager;
use VNDR\Model\Token;
use VNDR\Model\UserTokenModel;

class UserToken
{

    /**
     * Generate token
     *
     * @return string
     */
    static public function generateToken()
    {
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.org",
            "nbf" => TOKEN_NOT_BEFORE_VALID,
            "exp" => time() + TOKEN_EXPIRATION
        );

        return JWT::encode($token, API_KEY);
    }

    /**
     * Get user by token
     *
     * @param $token
     * @return \Phalcon\Mvc\Model
     * @throws JsonRPCException
     * @throws \ART\JWT\DomainException
     * @throws \ART\JWT\SignatureInvalidException
     */
    static public function getUserByToken($token)
    {
        try {
            $token_object = JWT::decode($token, API_KEY);
        } catch (\Exception $e) {
            throw new JsonRPCException($e->getMessage());
        }

        $where = sprintf("token='%s'", $token);

        /** @var UserTokenModel $user_token */
        $user_token = UserTokenModel::findFirst($where);
        if ($user_token) {
            $user_id = $user_token->getUserId();

            $user_manager = new UserManager();
            $only_active = true;
            $user = $user_manager->getUserById($user_id, $only_active);

            return $user;
        } else {
            throw new JsonRPCException("Token failed, maybe hacking");
        }
    }
}