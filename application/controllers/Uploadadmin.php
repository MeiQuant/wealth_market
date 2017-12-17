<?php


use Illuminate\Database\Capsule\Manager as DB;

class UploadadminController extends AbstractController
{

    public $_valid = null;

    public $need_login = true;

    public function init()
    {

    }

    public function uploadAction()
    {
        $uploader = new Upload_Upload();
        try {
            $ret = $uploader->upload(UPLOAD_DIR);
            if ($ret) {
                echo json_encode($uploader->getUploadFileInfo());
            } else {
                echo json_encode($uploader->getErrorMsg());
            }
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }

    }



}
