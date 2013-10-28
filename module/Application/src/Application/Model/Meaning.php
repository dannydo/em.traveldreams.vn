<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


class Meaning {

    public $MeaningId;
    public $WordId;
    public $LanguageId;
    public $Meaning;
    public $CreatedBy;
    public $CreatedDate;
    public $UpdatedBy;
    public $UpdatedDate;
    public $ApprovedBy;
    public $IsApproved;


    public function exchangeArray($data) {
        $this->MeaningId     = (!empty($data['MeaningId'])) ? $data['MeaningId'] : null;
        $this->WordId = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->LanguageId  = (!empty($data['LanguageId'])) ? $data['LanguageId'] : null;
        $this->Meaning  = (!empty($data['Meaning'])) ? $data['Meaning'] : null;
        $this->CreatedBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->CreatedDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->UpdatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->UpdatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->ApprovedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->IsApproved  = (!empty($data['IsApproved'])) ? $data['IsApproved'] : null;
    }
} 