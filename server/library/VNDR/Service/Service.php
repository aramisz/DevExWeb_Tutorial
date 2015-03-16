<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 01.
 * Time: 16:21
 */

namespace VNDR\Service;


use ART\Debug;
use VNDR\Data\Response;

class Service
{
    CONST TOKEN_KEY = "auth-token";

    /**
     * @var Response
     */
    public $response;

    public function __construct()
    {
        $this->getHeaders();
        $this->response = new Response();
    }

    /**
     * Get headers
     *
     * @return mixed
     */
    public function getHeaders()
    {
        $headers = apache_request_headers();
        return $headers;
    }

    /**
     * Get token if exists
     *
     * @return bool
     */
    public function getToken()
    {
        $headers = $this->getHeaders();
        if (array_key_exists(self::TOKEN_KEY, $headers)) {
            return $headers[self::TOKEN_KEY];
        } else {
            return false;
        }
    }
}