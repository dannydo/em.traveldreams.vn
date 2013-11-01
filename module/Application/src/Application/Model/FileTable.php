<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:17 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Debug\Debug;

class FileTable extends AbstractTableGateway {

    protected $table = 'Files';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new File());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    public function generalFolderName($fileId) {
        $folderName = (int)($fileId/1000 + 1);
        $dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$folderName;

        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    public function getFileByFileId($fileId) {
        return $this->select(array('FileId' => $fileId))->current();
    }

    public function getFileBySHA1($strSha1) {
        return $this->select(array('SHA1' => $strSha1))->current();
    }


    public function addFile($dataFile) {
        if($dataFile['error']) {
            return false;
        }

        $targetTemp = $_SERVER['DOCUMENT_ROOT'].'/temp/'.$dataFile['name'];
        move_uploaded_file( $dataFile['tmp_name'], $targetTemp);
        $strSha1 = sha1_file($targetTemp);

        $file = $this->getFileBySHA1($strSha1);
        if(isset($file->FileId)) {
            return $file->FileId;
        }

        $info = pathinfo($dataFile['name']);
        $data['Name'] = $dataFile['name'];
        $data['Extension'] = $info['extension'];
        $data['MimeType'] = $dataFile['type'];
        $data['SHA1'] = $strSha1;
        $data['IsActive'] = 1;

        if ($this->insert($data) > 0) {
            $fileId = $this->lastInsertValue;
            $targetUploads =  $this->generalFolderName($fileId).'/'.$fileId.'.'.$data['Extension'];
            copy($targetTemp, $targetUploads);
            unlink($targetTemp);

            return $fileId;
        }

        return false ;
    }

    public function deleteFile($fileId) {
        $file = $this->getFileByFileId($fileId);
        if(isset($file->FileId)) {
            $voiceTable = new VoiceTable();
            $voices = $voiceTable->getVoiceByFileId($fileId);
            if($voices->count() == 0) {
                if($this->delete(array('FileId' => $fileId)) > 0) {
                    $targetUploads =  $this->generalFolderName($fileId).'/'.$fileId.'.'.$file->Extension;
                    unlink($targetUploads);
                }
            }
        }
    }
} 