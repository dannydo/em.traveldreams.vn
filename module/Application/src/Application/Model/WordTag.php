<?php
/**
 * Created by JetBrains PhpStorm.
 * User: van.dao
 * Date: 10/30/13
 * Time: 8:44 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;


class WordTag {

    public $WordTagId;
    public $TagId;
    public $WordId;

    public function exchangeArray($data) {
        $this->WordTagId     = (!empty($data['WordTagId'])) ? $data['WordTagId'] : null;
        $this->TagId = (!empty($data['TagId'])) ? $data['TagId'] : null;
        $this->WordId  = (!empty($data['WordId'])) ? $data['WordId'] : null;
    }
}