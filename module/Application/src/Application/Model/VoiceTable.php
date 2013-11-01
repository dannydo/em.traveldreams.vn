<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class VoiceTable extends AbstractTableGateway {

    protected $table = 'Voices';

    public $objectType = array(
        1 => 'WORD',
        2 => 'SENTENCE'
    );

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
    }

    /**
     * Get voices for word by language id
     *
     * @param $wordId
     * @param int $languageId
     * @return array
     */
    public function getVoicesForWord($wordId, $languageId = 1) {
        $select = new Select();
        $select->from($this->table)
            ->join('AccentTypes', 'AccentTypes.AccentTypeId = Voices.AccentTypeId')
            ->join('Files', 'Files.FileId = Voices.FileId')
            ->where(array('ObjectId' => $wordId, 'ObjectType' => $this->objectType['1'], 'LanguageId' => $languageId));

        $records = array();
        foreach($this->selectWith($select) as $obj) {
            $records[] = $obj;
        }
        return $records;
    }

    public function getVoice($voiceId) {
        return $this->select(array('VoiceId' => $voiceId))->current();
    }

    public function getVoiceByFileId($fileId) {
        return $this->select(array('FileId' => $fileId));
    }

    public function addVoiceForWord($accentTypeId, $fileId, $languageId, $wordId) {
        $now = new \DateTime();
        $data['AccentTypeId'] = $accentTypeId;
        $data['FileId'] = $fileId;
        $data['LanguageId'] = $languageId;
        $data['ObjectId'] = $wordId;
        $data['ObjectType'] = $this->objectType['1'];
        $data['CreatedDate'] = $now->format('Y-m-d h:m:s');
        $data['CreatedBy'] = 1;
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $data['UpdatedBy'] = 1;

        $this->insert($data);
    }

    public function deleteVoice($voiceId) {
        $fileTable = new FileTable();
        $voice = $this->getVoice($voiceId);

        if(isset($voice->FileId)) {
            $fileId = $voice->FileId;
            if($this->delete(array('VoiceId' => $voiceId))) {
                $fileTable->deleteFile($fileId);
            }
        }
    }

    public function deleteVoices($arrVoiceId) {
        foreach($arrVoiceId as $voiceId) {
            if(is_numeric($voiceId) && $voiceId != '') {
                $this->deleteVoice($voiceId);
            }
        }
    }

    public function approveVoice($voiceId, $isApproved) {
        $this->update(array('IsApproved' => $isApproved), array('VoiceId' => $voiceId));
    }
} 