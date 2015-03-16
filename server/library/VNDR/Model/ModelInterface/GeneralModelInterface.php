<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 26.
 * Time: 10:30
 */

namespace VNDR\Model\ModelInterface;


interface GeneralModelInterface
{
    public function getId();
    public function getName();
    public function setName($name);
    public function save();
}