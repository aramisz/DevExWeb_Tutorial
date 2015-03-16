<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 02.
 * Time: 10:18
 */

namespace VNDR\Model;


use VNDR\Model\Base\UserTokenModelBase;

class UserTokenModel extends UserTokenModelBase
{
    /**
     * Save token for a specified user
     */
    public function saveToken()
    {
        $where = sprintf("user_id = %d AND client_agent = '%s'", $this->getUserId(), $this->getClientAgent());

        $result = parent::findFirst($where);

        if ($result) {
            // UPDATE TOKEN
            //$result->setExpiration(parent::getExpiration());
            $result->setToken(parent::getToken());
            $result->setModified(date("Y-m-d H:i:s", time()));
            $result->update();
        } else {
            // INSERT NEW TOKEN
            parent::setCreated(date("Y-m-d H:i:s", time()));
            parent::save();
        }
    }
}