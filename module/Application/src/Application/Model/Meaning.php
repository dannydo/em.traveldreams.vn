<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class Meaning {

    public $meaningId;
    public $wordId;
    public $languageId;
    public $meaning;
    public $createdBy;
    public $createdDate;
    public $updatedBy;
    public $updatedDate;
    public $approvedBy;
    public $isApproved;


    public function exchangeArray($data) {
        $this->meaningId     = (!empty($data['MeaningId'])) ? $data['MeaningId'] : null;
        $this->wordId = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->languageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->meaning  = (!empty($data['Meaning'])) ? $data['Meaning'] : null;
        $this->createdBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->createdDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->updatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->updatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->approvedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->isApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : null;
    }
} 