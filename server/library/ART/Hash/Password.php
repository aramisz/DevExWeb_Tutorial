<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 01. 16.
 * Time: 20:25
 */

namespace ART\Hash;


class Password {

    static function encodePassword($email, $password) {
        return sha1($email . $password);
    }
}