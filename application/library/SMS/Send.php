<?php

class SMS_Send
{
    const SMS_API  = "http://i.sms.weibo.cn/send?from=%s&srcid=%s&destid=%s&msg=%s";
    const FROM     = "108001";
    const LONG_NUM = "106900901801";
    const SUCCESS_CODE = 0;
    public static function send($mobile = '15010129801', $text = '')
    {
        $client = new \GuzzleHttp\Client(
            array(
                'timeout' => 2.0
            )
        );
        try {
            $text = urlencode(iconv("utf-8", "GBK", $text));
            $url = sprintf(self::SMS_API, self::FROM, self::LONG_NUM, $mobile, $text);
            $response = $client->get($url);
            $code = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $body = json_decode($body, true);
            if ($body['code'] == self::SUCCESS_CODE) {
                return true;
            }
            Cli::msg('send_message_fail', "发送短信失败, phone:{$mobile}, message: " . json_encode($body));
            return false;
        } catch (\Exception $e) {
            Cli::msg('send_message_exception', "发送短信失败, phone:{$mobile}, message: {$e->getMessage()}");
            return false;
        }


    }
}