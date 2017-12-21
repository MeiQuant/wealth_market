<?php

use Illuminate\Database\Capsule\Manager as DB;

class UserController extends IndexabstractController
{

    public $_valid = null;



    public function init()
    {
        $this->_valid = Validation::getInstance();
        $this->_callback_request_uri = $_SERVER['REQUEST_URI'];
        parent::init();

    }


    public function indexAction()
    {
        $open_id = $this->_uid;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->_valid->set_fields($_POST);
            $valid = $this->_valid->valid(
                'Models_User',
                array(
                    'phone' => 'is_valid_phone',
                    'email' => 'is_valid_email'
                )
            );
            if (!$valid['status']) {
                _error_json_encoder($valid['msg']);
            }
            $datetime = date('Y-m-d H:i:s');
            $province = $city = '';
            try {
                $username = Util_Common::post('username');
                $phone = Util_Common::post('phone');
                $email = Util_Common::post('email');
                $introduce = Util_Common::post('introduce');
                $company = Util_Common::post('company');
                $job = Util_Common::post('job');
                $province_city = Util_Common::post('province_city');
                if (!empty($province_city)) {
                    $province_city_arr = explode(',', $province_city);
                    $province = isset($province_city_arr[0]) ? $province_city_arr[0] : '';
                    $city = (isset($province_city_arr[1]) && $province_city_arr[1] != '市辖区') ? $province_city_arr[1] : (isset($province_city_arr[2]) ? $province_city_arr[2] : '');
                }
                $code = Util_Common::post('code');
                $introduce = empty($introduce) ? '有多年金融行业经验，具有丰富的理财业务知识，熟知各项理财产品，能根据市场变化，和客户个人情况，为其提供个性化服务。' : $introduce;
                $ret = Models_User::where('open_id', $open_id)->update(
                    array(
                        'username' => $username,
                        'phone' => $phone,
                        'email' => $email,
                        'introduce' => $introduce,
                        'company' => $company,
                        'job' => $job,
                        'province' => trim($province),
                        'city' => trim($city),
                        'code' => $code,
                        'update_time' => $datetime
                    )
                );

                if ($ret !== false) {
                    _success_json_encoder('添加成功');
                } else {
                    _error_json_encoder('保存失败, 请联系管理员');
                }


            } catch (Exception $e) {
                print_r($e->getMessage());die;
                _error_json_encoder('保存失败, 请联系管理员');
            }
        }

        $user = DB::table('finance_user')->where('open_id', $open_id)->first();

        $http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $redis_userinfo = $this->_redis->hgetall($open_id . 'user_info');

        if (strpos($http_referer, 'user/upload') !== false && !empty($redis_userinfo)) {
            $user['username'] = empty($user['username']) ? $redis_userinfo['username'] : $user['username'];
            $user['phone'] = empty($user['phone']) ? $redis_userinfo['phone'] : $user['phone'];
            $user['email'] = empty($user['email']) ? $redis_userinfo['email'] : $user['email'];
            $user['introduce'] = empty($user['introduce']) ? $redis_userinfo['introduce'] : $user['introduce'];
            $user['company'] = empty($user['company']) ? $redis_userinfo['company'] : $user['company'];
            $user['job'] = empty($user['job']) ? $redis_userinfo['job'] : $user['job'];
            $user['province'] = empty($user['province']) ? $redis_userinfo['province'] : $user['province'];
            $user['city'] = empty($user['city']) ? $redis_userinfo['city'] : $user['city'];
        }
        $this->getView()->assign(['user' => $user]);
        $this->getView()->display('user/index.html');
    }


    /**
     * 上传微信二维码
     */
    public function uploadAction()
    {
        $user = DB::table('finance_user')->where('open_id', $this->_uid)->first();
        $this->getView()->assign(['code' => $user['code']]);
        $this->getView()->display('user/upload.html');
    }


    /**
     * 用户跳转到二维码页面之前存储信息到mc中
     */
    public function storeAction()
    {
        $open_id = $this->_uid;
        $request = $this->getRequest();
        if ($request->isPost()) {
            try {
                $username = Util_Common::post('username');
                $phone = Util_Common::post('phone');
                $email = Util_Common::post('email');
                $introduce = Util_Common::post('introduce');
                $company = Util_Common::post('company');
                $job = Util_Common::post('job');
                $province_city = Util_Common::post('province_city');
                $province = $city = '';
                if (!empty($province_city)) {
                    $province_city_arr = explode(',', $province_city);
                    $province = isset($province_city_arr[0]) ? $province_city_arr[0] : '';
                    $city = (isset($province_city_arr[1]) && $province_city_arr[1] != '市辖区') ? $province_city_arr[1] : (isset($province_city_arr[2]) ? $province_city_arr[2] : '');
                }
                $ret = $this->_redis->hmset($open_id . 'user_info', ['username' => $username, 'phone' => $phone, 'email' => $email, 'introduce' => $introduce, 'company' => $company, 'job' => $job, 'province' => $province, 'city' => $city]);
                if ($ret === false) {
                    $this->_redis->hmset($open_id . 'user_info', ['username' => $username, 'phone' => $phone, 'email' => $email, 'introduce' => $introduce, 'company' => $company, 'job' => $job, 'province' => $province, 'city' => $city]);
                } else {
                    _success_json_encoder('ok');
                }


            } catch (Exception $e) {
                _error_json_encoder('保存失败, 请联系管理员');
            }
        }
    }


    public function testAction()
    {
        print_r($this->_redis->hgetall('oQt5h03tsXD7Wn6wWqzYDJ0umbEkuser_info'));die;
    }



}
