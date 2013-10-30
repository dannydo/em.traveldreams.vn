<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/30/13
 * Time: 6:27 PM
 */

namespace Application\Model;


class Tag {

    public $TagId;
    public $TagName;
    public $IsActive;

    public function exchangeArray($data) {
        $this->TagId     = (!empty($data['TagId'])) ? $data['TagId'] : null;
        $this->TagName = (!empty($data['TagName'])) ? $data['TagName'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 