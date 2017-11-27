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
        $ret = $uploader->upload(UPLOAD_DIR);
        if ($ret)
        {
            echo json_encode($uploader->getUploadFileInfo());exit;
        } else {
            return json_encode($uploader->getErrorMsg());
        }
    }



}
