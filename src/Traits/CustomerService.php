<?php
namespace Radish\WeChat\Traits;

use Radish\network\Curl;

/**
* @author Radish 1004622952@qq.com 2019-03-15
* 微信公众号Api接口(新客服系统)
*/

trait CustomerService
{
    /**
     * 将消息转发至客服
     * @param  array  $param
     * @return xml
     */
    public function transferCS(array $param)
    {
        !isset($param['MsgType']) && $param['MsgType'] = 'transfer_customer_service';
        $xml = $this->arrayToXml($param);

        return $xml;
    }

    /**
     * 请求并获取客服列表
     * @return array 客服列表数组
     */
    public function getCSList()
    {
        $json = Curl::get($this->getCSApiUrl('CSListUrl'));

        return $this->getMessage($json, '获取客服列表失败!');
    }

    /**
     * 获取在线客服列表
     * @return array
     */
    public function getOLCSList()
    {
        $json = Curl::get($this->getCSApiUrl('OLCSListUrl'));

        return $this->getMessage($json, '获取在线客服列表失败！');
    }

    /**
     * 添加客服
     * @param array $param 添加信息
     */
    public function addCS(array $param)
    {
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $result = Curl::post($this->getCSApiUrl('addCSUrl'), $json, $options);

        return $this->getMessage($result, "添加客服失败！");
    }

    /**
     * 邀请绑定客服操作
     * @param  array  $param 客服参数
     * @return array        微信响应数据
     */
    public function invitBindCS(array $param)
    {
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $result = Curl::post($this->getCSApiUrl('inviteBindCSUrl'), $json, $options);

        return $this->getMessage($result, '邀请失败！');
    }


    /**
     * 跟新客服昵称
     * @param  array  $param 相关参数
     * @return array         微信响应信息
     */
    public function updateCS(array $param)
    {
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $result = Curl::post($this->getCSApiUrl('updateCSUrl'), $json, $options);

        return $this->getMessage($result, '跟新失败！');
    }

    /**
     * 上传客服头像
     * @param  string $CSAccount 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param         $media     图片信息
     * @return array             微信响应信息
     */
    public function updateCSImg(string $CSAccount, $param)
    {
        // $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $url = $this->getCSApiUrl('uploadCSImgUrl') . '&kf_account=' . $CSAccount;
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $result = Curl::post($url, $param, $options);

        return $this->getMessage($result, '上传客服头像失败！');
    }

    /**
     * 删除客服
     * @param  string $CSAccount 客服账号
     * @return array            微信响应信息
     */
    public function deleteCS(string $CSAccount)
    {
        $url = $this->getCSApiUrl('deleteCSUrl') . '&kf_account=' . $CSAccount;
        $result = Curl::get($url);

        return $this->getMessage($result, '删除客服失败！');
    }

    protected function getCSApiUrl($key)
    {
        $apiUrls = [
            // http请求方式: GET 客服列表
            'CSListUrl' => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=',
            // http请求方式: GET 在线客服列表
            'OLCSListUrl' => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=',
            // http请求方式: POST 添加客服
            'addCSUrl' => 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=',
            // http请求方式: POST 邀请绑定客服
            'inviteBindCSUrl' => 'https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=',
            // http请求方式: POST 跟新客服
            'updateCSUrl' => 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=',
            // http请求方式: POST/FORM 上传客服头像
            'uploadCSImgUrl' => 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=',
            // http请求方式: GET 删除客服  
            'deleteCSUrl' => 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=',
        ];

        return $apiUrls[$key] . $this->getAccessToken();
    }
}