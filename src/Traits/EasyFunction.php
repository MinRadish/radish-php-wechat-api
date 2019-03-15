<?php
namespace Radish\WeChat\Traits;

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
        $array = [$signature, $timestamp, $nonce];
        sort($array, SORT_STRING);
        $string = implode($array);
        $string = sha1($string);
        if ($string == $signature) {
            $echoStr = $_GET['echostr'];
            header('content-type:text');

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
     * 转换发送者与接收者
     * @param  array $array 关注着发送的XMl
     * @return array 包含发送者和接收者信息
     */
    public function transformation(array $array)
    {
        return ['ToUserName' => $array['FromUserName'], 'FromUserName' => $array['ToUserName']];
    }
}