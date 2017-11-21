<?php

/**
 * Class AbstractController
 */
abstract class AbstractController extends Yaf_Controller_Abstract
{

    public $params = array();

    public $user = array();
    public $need_login = false;

    public $_config = null;

    public $page_members = array(
         'congcong6', 'wenjun8', 'lilin6', 'wantao', 'chenxi23', 'hongjun6'
    );

    /**
     * 登录、权限判断、初始化
     */
    public function init()
    {
        header("Content-Type:text/html;charset=utf-8");
        if ($this->need_login && !Ldap::getUser() ) {
            $this->redirect('/login/index');
        }

        $config = Models_Config::first();

        if (!empty($config))
        {
            $this->_config = $config;
        }
        $this->user['username'] = Ldap::getUser()['id'];

    }

    /**
     * 上传
     * @param $allowType
     * @param $savePath
     * @param bool|false $thumb
     * @param string $width
     * @param string $height
     * @param string $prefix
     * @param string $maxSize
     * @param bool|false $remove
     * @return mixed
     */
    public function upload($allowType, $savePath, $thumb = false, $width = '', $height = '', $prefix = '', $maxSize='', $remove = false)
    {

        $upload = new Upload_Upload();

        // 设置上传文件大小
        $upload->maxSize = empty($maxSize) ? getConfig('upload', 'max_size'): $maxSize;

        if ($thumb) {
            $upload->thumb = $thumb;
            $upload->thumbPrefix = $prefix;
            $upload->thumbMaxWidth = $width;
            $upload->thumbMaxHeight = $height;
            $upload->thumbRemoveOrigin = $remove;
        }

        // 设置上传文件类型
        $upload->allowExts = $allowType;

        // 设置附件上传目录
        $upload->savePath = $savePath;

        // 设置上传文件规则
        $upload->saveRule = 'uniqid';

        if (!$upload->upload()) {
            return ['status' => 0, 'msg' => $upload->getErrorMsg()];
        } else {

            // 取得成功上传的文件信息
            $info = $upload->getUploadFileInfo();
            return ['status' => 1, 'msg' => $info[0]['savename']];
        }
    }

}
