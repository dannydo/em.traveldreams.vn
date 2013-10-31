<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class Sentence {

    public $SentenceId;
    public $ParentSentenceId;
    public $LanguageId;
    public $WordId;
    public $Sentence;
    public $CreatedBy;
    public $CreatedDate;
    public $UpdatedBy;
    public $UpdatedDate;
    public $ApprovedBy;
    public $IsApproved;
    public $IsActive;


    public function exchangeArray($data) {
        $this->SentenceId     = (!empty($data['SentenceId'])) ? $data['SentenceId'] : null;
        $this->ParentSentenceId = (!empty($data['ParentSentenceId'])) ? $data['ParentSentenceId'] : null;
        $this->LanguageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->WordId  = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->Sentence  = (!empty($data['Sentence'])) ? $data['Sentence'] : null;
        $this->CreatedBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->CreatedDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->UpdatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->UpdatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->ApprovedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->IsApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : 0;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : 0;
    }
} 