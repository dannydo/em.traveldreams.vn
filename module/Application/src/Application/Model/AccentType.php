<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:16 PM
 */

namespace Application\Model;


class AccentType {

    public $accentTypeId;
    public $accentName;
    public $isActive;

    public function exchangeArray($data) {
        $this->accentTypeId     = (!empty($data['AccentTypeId'])) ? $data['AccentTypeId'] : null;
        $this->accentName = (!empty($data['AccentName'])) ? $data['AccentName'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 