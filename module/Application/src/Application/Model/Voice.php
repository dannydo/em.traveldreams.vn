<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


class Voice {

    public $VoiceId;
    public $AccentTypeId;
    public $FileId;
    public $LanguageId;
    public $ObjectId;
    public $ObjectType;
    public $CreatedBy;
    public $CreatedDate;
    public $UpdatedBy;
    public $UpdatedDate;
    public $ApprovedBy;
    public $IsApproved;


    public function exchangeArray($data) {
        $this->VoiceId     = (!empty($data['VoiceId'])) ? $data['VoiceId'] : null;
        $this->AccentTypeId = (!empty($data['AccentTypeId'])) ? $data['AccentTypeId'] : null;
        $this->FileId  = (!empty($data['FileId'])) ? $data['FileId'] : null;
        $this->LanguageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->ObjectId  = (!empty($data['ObjectId'])) ? $data['ObjectId'] : null;
        $this->ObjectType  = (!empty($data['ObjectType'])) ? $data['ObjectType'] : null;
        $this->CreatedBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->CreatedDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->UpdatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->UpdatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->ApprovedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->IsApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : null;
    }
} 