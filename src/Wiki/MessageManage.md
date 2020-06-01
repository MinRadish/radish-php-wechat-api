# 公众号客服消息

## 发送图文消息
~~~
$wechat->sendMsg($param);
~~~
**$param示例**
~~~
$param = [
    'touser' => OPENID,
    'msgtype' => 'text',
    'text' => [
        'content' => 'test',
    ],
];
~~~
## 发送图片消息
~~~
$wechat->sendMsg($param);
~~~
**$param示例**
~~~
$param = [
    'touser' => $openId,
    'msgtype' => 'image',
    'image' => [
        'media_id' => $message,
    ],
];
~~~

# 发送模板消息

## 发送模板消息
`$wechat->sendTpl($params);`
**$param示例**
~~~
$param = [
    'miniprogram' => [
        'appid' => '',
        'page' => '',
    ],
    'data' => [
        'first' => [
            'value' => '报警数量告警提醒',
        ],
        'content' => [
            'value' => '陕D58C17',
        ],
        'occurtime' => [
            'value' => '2020-05-19 11:24:00',
        ],
        'remark' => [
            'value' => '7车辆已产生',
        ],
    ],
    'template_id' => 'HNtKSdwSeB_Ro4xEq-DGtFx7c0dpvp7sQmDmyzf_eqA',
    'touser' => 'oMO8f1OVyTia0wdX8BXQ_oaFbzK8',
],;
~~~