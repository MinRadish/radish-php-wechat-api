<?php
namespace Radish\WeChat\Exception;

/**
* @author Radish 1004622952@qq.com 2019-03-15
* 微信公众号API错误异常类
*/

class WeChatException extends \Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function message()
    {
        return $this->message;
    }
}