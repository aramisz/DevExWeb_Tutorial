<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 10.
 * Time: 12:39
 *
 * Call service with the following procedure
 *
 * Auth/User::login
 *
 */

namespace ART\Ws\Bridge;


use ART\Debug;
use ART\Ws\Adapter\JsonRPC\JsonRPCError;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use ART\Ws\Adapter\JsonRPC\JsonRPCResponse;
use ART\Ws\Adapter\JsonRPC\JsonRPCServer;
use ART\Ws\WsException;
use BL\Service\User\Auth;

class JsonRPCBridge {

    protected $namespace;
    protected $class;
    protected $method;
    protected $params;
    protected $jsonRPCRequest;

    private $config;
    private $namespace_delimiter = "/";
    private $method_delimiter = "::";

    public function __construct(JsonRPCServer $jsonRPCRequest, $config = null)
    {
        try {
            if (!($config != null && is_array($config))) {
                throw new WsException("Needs to be add Service prefix", JsonRPCError::ERROR_INVALID_METHOD);
            }

            $this->config = $config;

            if ($jsonRPCRequest instanceof JsonRPCServer) {
                $this->setJsonRPCRequest($jsonRPCRequest);

                $method = $jsonRPCRequest->getMethod();
                $parts = explode($this->method_delimiter, $method);

                if (count($parts) == 2) {
                    $parts[0] = $this->config["namespace_prefix"] . $this->namespace_delimiter . $parts[0];
                    $class = str_replace($this->namespace_delimiter, "\\", $parts[0]);
                    $method = $parts[1];

                    $this->setClass($class);
                    $this->setMethod($method);
                } else {
                    $this->setMethod($parts[0]);
                }

                $this->setParams($jsonRPCRequest->getParams());
            }
        } catch (JsonRPCException $e) {

            $jsonRPCResponse = new JsonRPCResponse();
            $error = new JsonRPCError($e->getMessage(), $e->getCode());
            return $jsonRPCResponse->getResponse($error);
        }

    }

    /**
     * @return array
     */
    public function callService()
    {
        $class = $this->getClass();
        //$class = "VNDR\\Service\\User\\UserAuthService";
        $class = new $class;

        $jsonRPCResponse = new JsonRPCResponse($this->getJsonRPCRequest());

        try {

            if (!is_callable(array($class, $this->getMethod()))) {
                throw new JsonRPCException("Method is not callable!", JsonRPCError::ERROR_INVALID_METHOD);
            }
            $response = call_user_func_array(array($class, $this->getMethod()), $this->getParams());
            return $jsonRPCResponse->getResponse($response);

        } catch (JsonRPCException $e) {

            $error = new JsonRPCError($e->getMessage(), $e->getCode());
            return $jsonRPCResponse->getResponse($error);

        }

    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getJsonRPCRequest()
    {
        return $this->jsonRPCRequest;
    }

    /**
     * @param mixed $jsonRPCRequest
     */
    public function setJsonRPCRequest($jsonRPCRequest)
    {
        $this->jsonRPCRequest = $jsonRPCRequest;
    }



} 