<?php
namespace Radish\WeChat\Traits;

use Radish\Network\Curl;
use Radish\WeChat\Exception\WeChatException;

/**
* @author Radish 1004622952@qq.com 2019-03-20
* 微信公众号Api接口(新客服系统-会话控制)
*/

trait CustomerServiceSession
{

    /**
     * 获取客服聊天记录
     * @param  array  $param 强求参数
     * @return array        聊天记录
     */
    public function getCSMsgList(array $param)
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $param = json_encode($param, JSON_UNESCAPED_UNICODE);
        $result = Curl::post($this->getSessionApiUrl('getCSMsgList'), $param, $options);

        return $this->getMessage($result, '获取客服聊天记录失败！');
    }

    /**
     * 请求地址
     * @param  string $key key
     * @return  string    URL
     */
    protected function getSessionApiUrl($key)
    {
        $urlMap = [
            // http请求方式: POST
            'getCSMsgList' => 'https://api.weixin.qq.com/customservice/msgrecord/getmsglist?access_token=',
        ];

        return $urlMap[$key] . $this->getAccessToken();
    }
}