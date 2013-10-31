<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


class Word {

    public $WordId;
    public $Word;
    public $Status;
    public $CreatedBy;
    public $CreatedDate;
    public $UpdatedBy;
    public $UpdatedDate;
    public $ApprovedBy;
    public $IsActive;

    public function exchangeArray($data) {
        $this->WordId = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->Word     = (!empty($data['Word'])) ? $data['Word'] : null;
        $this->Status  = (!empty($data['Status'])) ? $data['Status'] : null;
        $this->CreatedBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->CreatedDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->UpdatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->UpdatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->ApprovedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->IsActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : 0;
    }
} 