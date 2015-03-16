<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        __DIR__ . '/../../library/3rdParty/PHPExcel/Classes',
        __DIR__ . '/../../cli/Tasks'
    )
);

$loader->registerNamespaces(
    array(
        "Phalcon"   => __DIR__ . '/../../library/Phalcon/',
        "ART"       => __DIR__ . '/../../library/ART/',
        "VNDR"        =>  __DIR__ . '/../../library/VNDR/'
    )
);

$loader->register();
