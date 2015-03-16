<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 08.
 * Time: 19:03
 */

namespace ART\Ws\Adapter\JsonRPC;



use ART\Debug;

class JsonRPCServer {

    private $request_json_text;
    protected $method;
    protected $params;
    protected $version;
    protected $id;

    public function __construct($request_json_text)
    {
        $this->request_json_text = $request_json_text;
    }

    /**
     * Handle
     */
    public function handle()
    {
        if ($this->request_json_text === false) {
            throw new JsonRPCException('file_get_contents failed', -32603);
        }

        $request = json_decode($this->request_json_text, true);

        if (count($request) === 0) {
            throw new JsonRPCException("Invalid JSON-RPC response", -32603);
        }

        $request_keys = array_keys($request);

        if (in_array("method", $request_keys) && in_array("params", $request_keys) && in_array("id", $request_keys))
        {
            if (in_array("version", $request_keys) && $request["version"] === "1.1") {
                $this->setVersion("1.1");
            } elseif (in_array("jsonrpc", $request_keys) && $request["jsonrpc"] === "2.0") {
                $this->setVersion("2.0");
            } elseif (!in_array("jsonrpc", $request_keys) && !in_array("version", $request_keys)) {
                $this->setVersion("1.0");
            } else {
                throw new JsonRPCException("Invalid JSON-RPC response (version)", -32603);
            }

            if ($request["id"] === null) {
                throw new JsonRPCException("Invalid JSON-RPC response (id)", -32603);
            }

            if ($request["method"] === null) {
                throw new JsonRPCException("Invalid JSON-RPC response (method)", -32601);
            }

            $this->setId($request["id"]);
            $this->setMethod($request["method"]);
            $this->setParams($request["params"]);

            return $this;
        }
        else
        {
            throw new JsonRPCException("Invalid JSON-RPC response (general)", -32603);
        }
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

    public function getRequest()
    {
        return $this;
    }
} 