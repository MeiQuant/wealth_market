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
        try {
            $ret = $uploader->upload(UPLOAD_DIR);
            if ($ret)
            {
                $upload_info = $uploader->getUploadFileInfo();
                $ret = true;
                    if (!empty($upload_info) && isset($upload_info[0])) {
                        if (trim($_GET['flag'] == 'profile_upload')) {
                            $name = $upload_info[0]['savename'];
                            $code = IMG_URL . $name;
                            $ret = DB::table('finance_user')
                                ->where('open_id', $open_id)
                                ->update(['code' => $code]);
                        }
                        if ($ret !== false) {
                            error_log(json_encode($upload_info) . '， uid: ' . $open_id .'上传成功, time : ' . date('Y-m-d H:i:s') . PHP_EOL, 3, '/tmp/upload.log');
                            echo json_encode($upload_info);exit;
                        } else {
                            error_log($open_id . ',sql错误上传错误1, time : ' . date('Y-m-d H:i:s') . PHP_EOL, 3, '/tmp/upload.log');
                            echo json_encode($uploader->getErrorMsg());exit;
                        }

                    }


            } else {
                error_log($open_id . ' ,' . json_encode($uploader->getErrorMsg()) . '上传错误1, time : ' . date('Y-m-d H:i:s') . PHP_EOL, 3, '/tmp/upload.log');
                echo json_encode($uploader->getErrorMsg());exit;
            }

        } catch (\Exception $e) {
            error_log($open_id . ', ' . $e->getMessage() . '上传错误2, time : ' . date('Y-m-d H:i:s') . PHP_EOL, 3, '/tmp/upload.log');
        }


    }



}
