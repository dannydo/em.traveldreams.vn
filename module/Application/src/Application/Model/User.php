<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class User {
    public $UserId;
    public $FullName;
    public $Username;
    public $Password;
    public $IsActive;


    public function exchangeArray($data) {
        $this->UserId     = (!empty($data['UserId'])) ? $data['UserId'] : null;
        $this->FullName = (!empty($data['FullName'])) ? $data['FullName'] : null;
        $this->Username  = (!empty($data['Username'])) ? $data['Username'] : null;
        $this->Password  = (!empty($data['Password'])) ? $data['Password'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : 0;
    }
} 