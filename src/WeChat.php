<?php
namespace Radish\WeChat;

/**
* @author Radish
* 微信接口公共类
*/
abstract class WeChat
{
    protected static $AppID = 'wxb2d69ed0b2152ef6';
    protected static $AppSecret = 'c9261a72b7ce7382225abbf6c949170c';
    protected static $token = 'radish';

    use Traits\EasyFunction;
    use Traits\CustomerService;
    use Traits\CustomerServiceSession;
    use Traits\MessageManage;
    use Traits\AccessToken;
    use Traits\Material;
    use Traits\WebAuth;
    use Traits\UserManage;

    public function __construct(array $options = [])
    {
        if (isset($options['appId'])) {
            self::$AppID = $options['appId'];
        }
        if (isset($options['appSecret'])) {
            self::$AppSecret = $options['appSecret'];
        }
        if (isset($options['scope'])) {
            $this->scope = $options['scope'];
        }
    }
}