<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 16.
 * Time: 12:43
 */

namespace ART\Ws\Adapter\JsonRPC;
use ART\Debug;
use BL\Service\User\Auth;
use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Annotations\Collection;
use Phalcon\Mvc\Collection\Document;

/**
 * Class JsonRPCServicesMap
 * @package ART\Ws\Adapter\JsonRPC
 *
 *
 */
class JsonRPCServicesMap {

    protected $service_dir;
    protected $namespace_prefix;
    protected $namespace_delimiter = "/";

    /**
     * @param null $config
     *
     * $config = array(
     *      "service_dir" => absolute/path/to
     * )
     * @throws JsonRPCException
     */
    public function __construct($config = null)
    {
        if (!isset($config["service_dir"])) {
            throw new JsonRPCException("Service dir required");
        }

        $this->service_dir = $config["service_dir"];
        $this->namespace_prefix = $config["namespace_prefix"];
    }

    public function getAllServices()
    {
        $service_dir = $this->service_dir;
        $dirs = scandir($service_dir);

        $result = null;

        foreach ($dirs as $dir) {
            if ($dir == "." || $dir == ".." || !is_dir($service_dir . $dir)) {
                continue;
            }

            $serviceNamespace = ucfirst(basename($dir));
            $files = scandir($service_dir . $dir);

            foreach ($files as $file) {
                if ($file == "." || $file == "..") {
                    continue;
                }

                if (basename($file) != "test") {
                    $serviceName = str_replace(".php", "", basename($file));
                    $class = "{$serviceName}";
                    $service_url = ucfirst(strtolower($serviceNamespace)) . "/" . ucfirst(strtolower($serviceName)) . "/";

                    $m = array();

                    $parts = $this->namespace_prefix . $this->namespace_delimiter . $dir . $this->namespace_delimiter . $class;
                    $class = str_replace($this->namespace_delimiter, "\\", $parts);

                    $reflector = new \ReflectionClass($class);
                    $methods = $reflector->getMethods();

                    /** No needs Abstract classes to list */
                    if (!strstr($class, "Abstract")) {
                        if ($methods) {
                            foreach ($methods as $method) {

                                if ($method instanceof \ReflectionMethod) {

                                    if (!$method->isConstructor()) {

                                        if (!($method->isStatic() || $method->isPrivate() || $method->isProtected())) {
                                            $methodParams = array();
                                            $params = $method->getParameters();

                                            $doc = $method->getDocComment();

                                            foreach ($params as $param) {
                                                if ($param instanceof \ReflectionParameter) {

                                                    $paramName = $param->getName();

                                                    try {
                                                        $paramDefault = $param->getDefaultValue();
                                                    } catch (\ReflectionException $e) {
                                                        $paramDefault = "";
                                                    }

                                                    $paramOptional = $param->isOptional() ? 1 : 0;

                                                    $methodParams[] = array(
                                                        //"type" => $paramType,
                                                        "name" => $paramName,
                                                        "optional" => $paramOptional,
                                                        "default" => $paramDefault,
                                                        "position" => $param->getPosition()
                                                    );
                                                }
                                            }

                                            $m[$method->getName()]["doc"] = !empty($doc) ? $doc : "";
                                            $m[$method->getName()]["params"] = $methodParams;
                                        }
                                    }
                                }
                            }
                        }

                        $result["Services"][basename($dir)][$serviceName] = array(
                            "file" => basename($reflector->getFileName()),
                            "url" => $service_url,
                            "namespace" => $reflector->getNamespaceName(),
                            "class" => $class,
                            "class_short" => $reflector->getShortName(),
                            "methods" => $m

                        );
                    }
                }
            }
        }

        return $result;
    }


}