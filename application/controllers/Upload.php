<?php


use Illuminate\Database\Capsule\Manager as DB;

class UploadController extends AbstractController
{

    public $_valid = null;

    public $need_login = false;

    public function init()
    {
        $this->_valid = Validation::getInstance();
        parent::init();
    }

    public function uploadAction()
    {
        $uploader = new Upload_Upload();
        $ret = $uploader->upload('/data/upload_file/');
        if ($ret)
        {
            return $uploader->getUploadFileInfo();
        } else {
            return $uploader->getErrorMsg();
        }
    }



}
