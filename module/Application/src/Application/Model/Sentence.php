<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class Sentence {

    public $sentenceId;
    public $parentSentenceId;
    public $languageId;
    public $wordId;
    public $sentence;
    public $createdBy;
    public $createdDate;
    public $updatedBy;
    public $updatedDate;
    public $approvedBy;
    public $isApproved;
    public $isActive;


    public function exchangeArray($data) {
        $this->sentenceId     = (!empty($data['SentenceId'])) ? $data['SentenceId'] : null;
        $this->parentSentenceId = (!empty($data['ParentSentenceId'])) ? $data['ParentSentenceId'] : null;
        $this->languageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->wordId  = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->sentence  = (!empty($data['Sentence'])) ? $data['Sentence'] : null;
        $this->createdBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->createdDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->updatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->updatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->approvedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->isApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 