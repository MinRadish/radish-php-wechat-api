<?php
namespace Radish\WeChat\Traits;

use Radish\Network\Curl;
use Radish\WeChat\Exception\WeChatException;

/**
* @author Radish 1004622952@qq.com 2019-03-20
* 微信公众号消息管理API
*/

trait MessageManage
{

    /**
     * 发送消息
     * @param  array  $msg       以类型为KEY的数组
     * @param  string $type      消息类型
     * @param  string $CSAccount 客服唯一标识
     * @return array             微信响应数据
     */
    public function sendMsg(array $param, $CSAccount = '')
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        if ($CSAccount && !isset($param['customservice'])) {
            $param['customservice'] = ['kf_account' => $CSAccount];
        }
        $param = json_encode($param, JSON_UNESCAPED_UNICODE);
        $result = Curl::post($this->getMsgApiUrl('sendMessage'), $param, $options);

        return $this->getMessage($result, '发送消息失败！');
    }

    /**
     * 请求地址
     * @param  string $key key
     * @return  string    URL
     */
    protected function getMsgApiUrl($key)
    {
        $urlMap = [
            // http请求方式: POST
            'sendMessage' => 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=',
        ];

        return $urlMap[$key] . $this->getAccessToken();
    }
}