<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:17 PM
 */

namespace Application\Model;


class Language {

    public $languageId;
    public $name;
    public $code;
    public $isActive;

    public function exchangeArray($data) {
        $this->languageId     = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->code  = (!empty($data['Code'])) ? $data['Code'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 