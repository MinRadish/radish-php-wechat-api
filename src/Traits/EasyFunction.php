<?php
namespace Radish\WeChat\Traits;

use Radish\WeChat\Exception\WeChatException;
use Radish\Network\Curl;

/**
* @author Radish 1004622952@qq.com 2019-03-15
* 将微信公众号Api接口定义无需参数的处理方法
*/
trait EasyFunction
{
    /**
     * Token认证
     */
    public static function checkToken()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $array = array($timestamp, $nonce, self::$token);
        sort($array, SORT_STRING);
        $string = implode($array);
        $string = sha1($string);
        if ($string == $signature) {
            $echoStr = $_GET['echostr'];
            return $echoStr;
        } else {
            return false;
        }
    }

    /**
     * 输出xml字符
    **/
    public function arrayToXml(array $array, $time = true)
    {
        $xml = "<xml>";
        if (!isset($array['CreateTime']) && $time) {
            $array['CreateTime'] = time();
        }
        foreach ($array as $key => $val)
        {
            if (is_numeric($val)) {
                $xml .= "<".$key.">".$val."</".$key.">";
            } else if ($key == 'KfAccount') {
                $xml .= "<TransInfo><".$key."><![CDATA[".$val."]]></".$key."></TransInfo>";
            } else {
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml .= "</xml>";

        return $xml;
    }

    /**
     * 接收消息
     * @return xml 获取微信发送的XML
     */
    public function getXml()
    {
        return file_get_contents('php://input');
    }

    /**
     * XML转换成数组
     * @param  xml $xml 
     * @return array
     */
    public function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 获取微信公众号关注者发送的信息
     * @return array 
     */
    public function getUserNews()
    {
        $xml = $this->getXml();

        return $this->xmlToArray($xml);
    }

    /**
     * 获取微信服务器IP列表
     * @return array 
     */
    public function getServerIpList()
    {
        //HTTP GET
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . $this->getAccessToken();
        $result = Curl::get($url);

        return $this->getMessage($result, '获取微信服务器IP列表失败！');
    }

    /**
     * 转换发送者与接收者
     * @param  array $array 关注着发送的XMl
     * @return array 包含发送者和接收者信息
     */
    public function transformation(array $array)
    {
        return ['ToUserName' => $array['FromUserName'], 'FromUserName' => $array['ToUserName']];
    }

    /**
     * 获取请求时的错误信息
     * @param  json-string $json   微信响应数据
     * @param  string $message 信息提示
     * @return array          响应数据格式化后信息
     */
    protected function getMessage($json, $message = '未知错误！')
    {
        $array = json_decode($json, true);
        if (isset($array['errcode']) && $array['errcode'] != 0) {
            $mes = $this->getCodeMap($array['errcode']) ?: $message;
            throw new WeChatException($mes, $json);
        } else {
            return $array;
        }
    }

    /**
     * 获取错误代码
     * @param  string $key 代码
     * @return String 错误代码与信息
     */
    protected function getCodeMap($key)
    {
        $codeMap = [
            //新客服接口
            '0'     => '成功',
            '65400' => 'API不可用，即没有开通/升级到新版客服功能',
            '65401' => '无效客服帐号',
            '65403' => '客服昵称不合法',
            '65404' => '客服帐号不合法',
            '65405' => '帐号数目已达到上限，不能继续添加',
            '65406' => '已经存在的客服帐号',
            '65407' => '邀请对象已经是该公众号客服',
            '65408' => '本公众号已经有一个邀请给该微信',
            '65409' => '无效的微信号',
            '65410' => '邀请对象绑定公众号客服数达到上限（目前每个微信号可以绑定5个公众号客服帐号）',
            '65411' => '该帐号已经有一个等待确认的邀请，不能重复邀请',
            '65412' => '该帐号已经绑定微信号，不能进行邀请',
            '40005' => '不支持的媒体类型',
            '40009' => '媒体文件长度不合法',
            //获取access_token
            '-1' => '系统繁忙，此时请开发者稍候再试',
            '40001' => 'AppSecret错误或者AppSecret不属于这个公众号，请开发者确认AppSecret的正确性',
            '40002' => '请确保grant_type字段值为client_credential',
            '40164' => '调用接口的IP地址不在白名单中，请在接口IP白名单中进行设置。（小程序及小游戏调用不要求IP地址在白名单内。）',
            //web auth
            '10003' => 'redirect_uri域名与后台配置不一致',
            '10004' => '此公众号被封禁',
            '10005' => '此公众号并没有这些scope的权限',
            '10006' => '必须关注此测试号',
            '10009' => '操作太频繁了，请稍后重试',
            '10010' => 'scope不能为空',
            '10011' => 'redirect_uri不能为空',
            '10012' => 'appid不能为空',
            '10013' => 'state不能为空',
            '10015' => '公众号未授权第三方平台，请检查授权状态',
            '10016' => '不支持微信开放平台的Appid，请使用公众号Appid',
            '40029' => '无效的code',
            '40163' => 'code已被使用',
        ];
        $info = isset($codeMap[$key]) ? $codeMap[$key] : false;

        return $info;
    }
}