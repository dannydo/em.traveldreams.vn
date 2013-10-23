<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:17 PM
 */

namespace Application\Model;


class File {

    public $fileId;
    public $name;
    public $extension;
    protected $mimeType;
    protected $SHA1;
    protected $isActive;

    public function exchangeArray($data) {
        $this->fileId     = (!empty($data['FileId'])) ? $data['FileId'] : null;
        $this->name = (!empty($data['Name'])) ? $data['Name'] : null;
        $this->extension  = (!empty($data['Extension'])) ? $data['Extension'] : null;
        $this->mimeType  = (!empty($data['MimeType'])) ? $data['MimeType'] : null;
        $this->SHA1  = (!empty($data['SHA1'])) ? $data['SHA1'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 