<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 16.
 * Time: 16:51
 */

namespace VNDR\Service\Test;

use VNDR\Service\ServiceWithoutToken;

class TestTestWsService extends ServiceWithoutToken
{

    public function getAlma($a, $b = "asd")
    {
        return $a;
    }

    public function getTestWS()
    {

        return array(
            'valami',
            'még valami',
            array(
                'ize',
                'mize' => 5
            )
        );
    }

}