<?php
namespace Radish\WeChat\Traits;

use Radish\network\Curl;

/**
* @author Radish 1004622952@qq.com 2019-03-15
* 微信公众号Api接口(新客服系统)
*/

trait CustomerService
{
    //http请求方式: GET::get($this->getSe)
    private $serviceListApiUrl = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=';
    /**
     * 将消息转发至客服
     * @param  array  $param
     * @return xml
     */
    public function transferService(array $param)
    {
        !isset($param['MsgType']) && $param['MsgType'] = 'transfer_customer_service';
        $xml = $this->arrayToXml($param);

        return $xml;
    }

    protected function getServiceListApiUrl()
    {
        return $this->serviceListApiUrl . $this->getAccessToken();
    }

    public function serviceList()
    {
        $json = Curl::get($this->getServiceListApiUrl());
        dum($json);
    }

    public function getServiceCodeMap()
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