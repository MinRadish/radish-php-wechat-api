<?php
namespace Radish\WeChat\Traits;

use Radish\network\Curl;
use Radish\WeChat\Exception\WeChatException;

/**
* @author Radish 1004622952@qq.com 2019-03-15
* 微信公众号Api接口(新客服系统)
*/

trait CustomerService
{
    //http请求方式: GET
    private $_CSListUrl = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=';
    //http请求方式: GET 
    private $_OLCSListUrl = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=';
    // http请求方式: POST
    private $_addCSUrl = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=';

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
     * 获取客服列表API地址
     * @return string API地址
     */
    protected function getCSListUrl()
    {
        return $this->_CSListUrl . $this->getAccessToken();
    }

    /**
     * 请求并获取客服列表
     * @return array 客服列表数组
     */
    public function getCSList()
    {
        $json = Curl::get($this->getCSListUrl());

        return $this->getCSMessage($json, '获取客服列表失败!');
    }

    /**
     * 获取在线客服列表API地址
     * @return string API地址
     */
    protected function getOLCSListUrl()
    {
        return $this->_OLCSListUrl . $this->getAccessToken();
    }

    /**
     * 获取在线客服列表
     * @return array
     */
    public function getOLCSList()
    {
        $json = Curl::get($this->getOLCSListUrl());

        return $this->getCSMessage($json, '获取在线客服列表失败！');
    }

    /**
     * 获取添加客服信息API地址
     * @return string URL
     */
    protected function getAddCSUrl()
    {
        return $this->_addCSUrl . $this->getAccessToken();
    }

    /**
     * 添加客服
     * @param array $param 添加信息
     */
    public function addCS(array $param)
    {
        $json = json_encode($param, JSON_UNESCAPED_UNICODE);
        $result = Curl::post($this->getAddCSUrl(), $json);

        return $this->getCSMessage($result, "添加客服失败！");
    }

    /**
     * 获取请求时的错误信息
     * @param  json-string $json   微信响应数据
     * @param  string $message 信息提示
     * @return array          响应数据格式化后信息
     */
    protected function getCSMessage($json, $message = '未知错误！')
    {
        $array = json_decode($json, true);
        if (isset($array['errcode']) && $array['errcode'] != 0) {
            throw new WeChatException($this->getCSCodeMap($array['errcode']) || $message);
        } else {
            return $array;
        }
    }

    /**
     * 获取错误代码
     * @return String 错误代码与信息
     */
    public function getCSCodeMap()
    {
        return [
            '0'     =>  '成功',
            '65400' =>  'API不可用，即没有开通/升级到新版客服功能',
            '65401' =>  '无效客服帐号',
            '65403' =>  '客服昵称不合法',
            '65404' =>  '客服帐号不合法',
            '65405' =>  '帐号数目已达到上限，不能继续添加',
            '65406' =>  '已经存在的客服帐号',
            '65407' =>  '邀请对象已经是该公众号客服',
            '65408' =>  '本公众号已经有一个邀请给该微信',
            '65409' =>  '无效的微信号',
            '65410' =>  '邀请对象绑定公众号客服数达到上限（目前每个微信号可以绑定5个公众号客服帐号）',
            '65411' =>  '该帐号已经有一个等待确认的邀请，不能重复邀请',
            '65412' =>  '该帐号已经绑定微信号，不能进行邀请',
            '40005' =>  '不支持的媒体类型',
            '40009' =>  '媒体文件长度不合法',
        ];
    }
}