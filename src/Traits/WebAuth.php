<?php
/**
 * 
 * @authors Radish (1004622952@qq.com)
 * @date    2019-04-15 17:21:42
 */

namespace Radish\WeChat\Traits;

use Radish\WeChat\Exception\WeChatException;

trait WebAuth
{
    protected $scope = 'snsapi_base';// snsapi_base 静默授权(必须关注公众号) snsapi_userinfo 手动授权

    /**
     * 网页授权跳转
     * @param  string $url 授权后重定向的回调链接地址
     * @return String      跳转地址
     */
    public function webAuthRedirect(string $url, string $state = null)
    {
        $url = urlencode($url);

        return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . self::$AppID . '&redirect_uri=' . $url . '&response_type=code&scope=' . $this->scope . '&state=' . $state . '#wechat_redirect';
    }

    /**
     * 获取用户信息
     * @param  string $code code获取access_token凭证
     * @return mixed       用户信息
     */
    public function getUserInfo($code)
    {
        $tokenUrl = sprintf($this->getWebAuthApiUrl('access_token'), $code);
        $tokenResult = Curl::get($tokenUrl);
        $token = $this->getMessage($result, '获取AuthToken失败!');
        if ($this->scope == 'snsapi_userinfo') {
            $infoUrl = sprintf($this->getUserInfo('user_info'), $token['access_token'], $token['openid']);
            $userResult = Curl::get($infoUrl);
            return $this->getMessage($userResult, '获取用户信息失败!');
        }

        return $token;
    }

    /**
     * 获取微信网页授权需要的连接
     * @param  string $key 连接类型
     * @return string      URL连接
     */
    public function getWebAuthApiUrl($key)
    {
        $apiUrls = [
            //GET
            'access_token' => 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$AppID . '&secret=' . self::$AppSecret . '&code=%s&grant_type=authorization_code',
            //GET
            'user_info' => 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN',
        ];

        return $apiUrls[$key];
    }
}