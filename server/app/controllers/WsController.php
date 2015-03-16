<?php
use ART\Debug;
use ART\Ws\Adapter\JsonRPC\JsonRPCError;
use ART\Ws\Adapter\JsonRPC\JsonRPCException;
use ART\Ws\Adapter\JsonRPC\JsonRPCResponse;
use ART\Ws\Adapter\JsonRPC\JsonRPCServer;
use ART\Ws\Adapter\JsonRPC\JsonRPCServicesMap;
use ART\Ws\Bridge\JsonRPCBridge;
use Phalcon\Mvc\View;

/**
 * Class WsController
 *
 * for test:
 * {"jsonrpc": "2.0", "method": "subtract", "params": [42, 23], "id": 1}
 *
 * curl -i -X POST -d "{\"jsonrpc\":\"2.0\",\"method\":\"User/Auth::login\",\"params\":{\"username\":\"alma\",\"password\":\"paprika\"},\"id\":10}" http://bl_core/ws
 */
class WsController extends ControllerBase
{
    private $allowed_jsonrpc_version = "2.0";
    private $test_json = '{"jsonrpc": "2.0", "method": "User/Auth::login", "params": {"username": "alma", "password": "paprika"}, "id": 1}';

    /**
     *
     */
    public function indexAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, AUTH-TOKEN, Authorization");
        header('Content-Type: application/json', 'UTF-8');

        if ($this->request->isPost()) {
            $method = $this->request->getPost("method");
        }

        $request_text = file_get_contents('php://input');

//        $jsonrpc_server = new JsonRPCServer($this->test_json);
        $jsonrpc_server = new JsonRPCServer($request_text);

        try {

            //Debug::dump($jsonrpc_server);

            $config = array(
                "namespace_prefix" => "VNDR/Service"
            );

            $jsonRPCBridge = new JsonRPCBridge($jsonrpc_server->handle(), $config);
            $response = $jsonRPCBridge->callService();

        } catch (JsonRPCException $e) {

            $jsonRPCResponse = new JsonRPCResponse($jsonrpc_server);

            $error = new JsonRPCError($e->getMessage(), $e->getCode());
            $response = $jsonRPCResponse->getResponse($error);

        }

//        $json = json_encode($response, JSON_NUMERIC_CHECK);
        $json = $this->json_encode($response);
        echo $json;

    }

    function json_encode($arr)
    {
        //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
        array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
        return mb_decode_numericentity(json_encode($arr, JSON_NUMERIC_CHECK), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');

    }

    /**
     *
     */
    public function mapAction()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, AUTH-TOKEN, Authorization");
        header('Content-Type: application/json');

        $jsonRPCResponse = new JsonRPCResponse();

        try {

            $config = array(
//                "service_dir" => $this->config->vndr->VNDRServiceDir,
                "service_dir" => '../library/VNDR/Service/',
                "namespace_prefix" => "VNDR/Service"
            );

            $jsonRPCServiceMap = new JsonRPCServicesMap($config);
            $response = $jsonRPCResponse->getResponse($jsonRPCServiceMap->getAllServices());

        } catch (JsonRPCException $e) {

            $error = new JsonRPCError($e->getMessage(), $e->getCode());
            $response = $jsonRPCResponse->getResponse($error);

        }

        echo json_encode($response);
    }

}

