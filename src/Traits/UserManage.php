<?php
/**
 * 用户管理
 * @authors Radish (1004622952@qq.com)
 * @date    2019-04-16 09:05:11
 */

namespace Radish\WeChat\Traits;

trait UserManage
{
    /**
     * 获取用户信息
     * @param  string $openId 微信好在公众号微信标识OPEN_ID
     * @return mixed          用户信息
     */
    public function getUserManageInfo($openId)
    {
        $url = sprintf($this->getUserManageApiUrl('user_info'), $openId);
        $result = Curl::get($url);

        return $this->getMessage($result, '获取用户信息失败');
    }

    /**
     * 获取API请求地址
     * @param  string $key 相关类型
     * @return string      请求地址
     */
    public function getUserManageApiUrl($key)
    {
        $urls = [
            //GET
            'user_info' => 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $this->getAccessToken() . '&openid=%s&lang=zh_CN',
        ];

        return $urls[$key];
    }
}