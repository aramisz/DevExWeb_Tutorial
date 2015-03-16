<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 08.
 * Time: 19:09
 */

namespace ART\Ws\Adapter\JsonRPC;


class JsonRPCClient {
    private $uri;

    public function __construct($uri) {
        $this->uri = $uri;
    }

    private function generateId() {
        $chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
        $id = '';
        for($c = 0; $c < 16; ++$c)
            $id .= $chars[mt_rand(0, count($chars) - 1)];
        return $id;
    }

    public function __call($name, $arguments) {
        $id = $this->generateId();

        $request = array(
            'jsonrpc' => '2.0',
            'method'  => $name,
            'params'  => $arguments,
            'id'      => $id
        );

        $jsonRequest = json_encode($request);

        $ctx = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json\r\n',
                'content' => $jsonRequest
            )
        ));
        $jsonResponse = file_get_contents($this->uri, false, $ctx);

        if ($jsonResponse === false)
            throw new JsonRPCException('file_get_contents failed', -32603);

        $response = json_decode($jsonResponse);

        if ($response === null)
            throw new JsonRPCException('JSON cannot be decoded', -32603);

        if ($response->id != $id)
            throw new JsonRPCException('Mismatched JSON-RPC IDs', -32603);

        if (property_exists($response, 'error')) {
            throw new JsonRPCException($response->error->message, $response->error->code);
        }
        else if (property_exists($response, 'result')) {
            return $response->result;
        }
        else {
            throw new JsonRPCException('Invalid JSON-RPC response', -32603);
        }
    }
} 