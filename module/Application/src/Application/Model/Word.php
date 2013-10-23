<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


class Word {

    public $wordId;
    public $word;
    public $status;
    public $createdBy;
    public $createdDate;
    public $updatedBy;
    public $updatedDate;
    public $approvedBy;
    public $isActive;


    public function exchangeArray($data) {
        $this->wordId = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->word     = (!empty($data['Word'])) ? $data['Word'] : null;
        $this->status  = (!empty($data['Status'])) ? $data['Status'] : null;
        $this->createdBy  = (!empty($data['CreatedBy'])) ? $data['CreatedBy'] : null;
        $this->createdDate  = (!empty($data['CreatedDate'])) ? $data['CreatedDate'] : null;
        $this->updatedBy  = (!empty($data['UpdatedBy'])) ? $data['UpdatedBy'] : null;
        $this->updatedDate  = (!empty($data['UpdatedDate'])) ? $data['UpdatedDate'] : null;
        $this->approvedBy  = (!empty($data['ApprovedBy'])) ? $data['ApprovedBy'] : null;
        $this->isActive  = (!empty($data['IsActive'])) ? $data['IsActive'] : null;
    }
} 