<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


class Voice {

    public $voiceId;
    public $accentTypeId;
    public $fileId;
    public $languageId;
    public $objectId;
    public $objectType;
    public $createdBy;
    public $createdDate;
    public $updatedBy;
    public $updatedDate;
    public $approvedBy;
    public $isApproved;


    public function exchangeArray($data) {
        $this->voiceId     = (!empty($data['VoiceId'])) ? $data['VoiceId'] : null;
        $this->accentTypeId = (!empty($data['AccentTypeId'])) ? $data['AccentTypeId'] : null;
        $this->fileId  = (!empty($data['FileId'])) ? $data['FileId'] : null;
        $this->languageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->languageId  = (!empty($data['ObjectId'])) ? $data['ObjectId'] : null;
        $this->languageId  = (!empty($data['ObjectType'])) ? $data['ObjectType'] : null;
        $this->createdBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->createdDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->updatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->updatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->approvedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->isApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : null;
    }
} 