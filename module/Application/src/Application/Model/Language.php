<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:17 PM
 */

namespace Application\Model;


class Language {

    public $LanguageId;
    public $Name;
    public $Code;
    public $IsActive;

    public function exchangeArray($data) {
        $this->LanguageId     = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->Name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->Code  = (!empty($data['Code'])) ? $data['Code'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : 0;
    }
} 