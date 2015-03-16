<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 15.
 * Time: 17:06
 */

namespace ART\Ws\Adapter\JsonRPC;


use ART\Debug;

class JsonRPCResponse
{
    protected $version = "2.0";
    protected $result;
    protected $error;
    protected $id = null;
    protected $jsonRPCRequest;

    /**
     * Constructor
     *
     * @param JsonRPCServer $jsonRPCRequest
     */
    public function __construct(JsonRPCServer $jsonRPCRequest = null)
    {
        $this->setJsonRPCRequest($jsonRPCRequest);

        if ($jsonRPCRequest instanceof JsonRPCServer) {
            if ($jsonRPCRequest->getVersion() == "2.0") {
                $this->setVersion($jsonRPCRequest->getVersion());
                $this->setId($jsonRPCRequest->getId());
            }
        }
    }

    /**
     * Get response
     *
     * @param $response
     * @return array
     */
    public function getResponse($response)
    {

        if ($this->getVersion() == "2.0") {
            // If has error
            if ($response instanceof JsonRPCError) {
                return array(
                    "jsonrpc" => $this->getVersion(),
                    "error" => $response->toArray(),
                    "id" => $this->getId()
                );
            }

            return array(
                "jsonrpc" => $this->getVersion(),
                "result" => $response,
                "id" => $this->getId()
            );
        }
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getJsonRPCRequest()
    {
        return $this->jsonRPCRequest;
    }

    /**
     * @param JsonRPCServer $jsonRPCRequest
     */
    public function setJsonRPCRequest($jsonRPCRequest)
    {
        $this->jsonRPCRequest = $jsonRPCRequest;
    }

}