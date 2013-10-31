<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:16 PM
 */

namespace Application\Model;


class AccentType {

    public $AccentTypeId;
    public $AccentName;
    public $IsActive;

    public function exchangeArray($data) {
        $this->AccentTypeId     = (!empty($data['AccentTypeId'])) ? $data['AccentTypeId'] : null;
        $this->AccentName = (!empty($data['AccentName'])) ? $data['AccentName'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : 0;
    }
} 