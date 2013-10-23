<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class User {
    public $userId;
    public $fullName;
    public $username;
    public $password;
    public $isActive;


    public function exchangeArray($data) {
        $this->userId     = (!empty($data['UserId'])) ? $data['UserId'] : null;
        $this->fullName = (!empty($data['FullName'])) ? $data['FullName'] : null;
        $this->username  = (!empty($data['Username'])) ? $data['Username'] : null;
        $this->password  = (!empty($data['Password'])) ? $data['Password'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 