<?php


use Illuminate\Database\Capsule\Manager as DB;

class UploadController extends IndexabstractController
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
        $open_id = $this->_uid;
        $uploader = new Upload_Upload();
        $ret = $uploader->upload(UPLOAD_DIR);
        if ($ret)
        {
            $upload_info = $uploader->getUploadFileInfo();
            $ret = true;
            try {
                if (!empty($upload_info) && isset($upload_info[0])) {
                    if (trim($_GET['flag'] == 'profile_upload')) {
                        $name = $upload_info[0]['savename'];
                        $code = IMG_URL . $name;
                        $ret = DB::table('finance_user')
                            ->where('open_id', $open_id)
                            ->update(['code' => $code]);
                    }
                    if ($ret !== false) {
                        echo json_encode($upload_info);exit;
                    } else {
                        echo json_encode($uploader->getErrorMsg());exit;
                    }

                }

            } catch (\Exception $e) {
                // exception
                print_r('error');exit;
            }
        } else {
            echo json_encode($uploader->getErrorMsg());exit;
        }
    }



}
