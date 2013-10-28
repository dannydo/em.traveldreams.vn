<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:17 PM
 */

namespace Application\Model;


class File {

    public $FileId;
    public $Name;
    public $Extension;
    public $MimeType;
    public $SHA1;
    public $IisActive;

    public function exchangeArray($data) {
        $this->FileId     = (!empty($data['FileId'])) ? $data['FileId'] : null;
        $this->Name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->Extension  = (!empty($data['Extension'])) ? $data['Extension'] : null;
        $this->MimeType  = (!empty($data['MimeType'])) ? $data['MimeType'] : null;
        $this->SHA1  = (!empty($data['SHA1'])) ? $data['SHA1'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 