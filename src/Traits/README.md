# MessageManage.php 文件说明

*接口调用请求说明*

http请求方式: POST
https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN
各消息类型所需的JSON数据包如下：

## 发送文本消息

{
    "touser":"OPENID",
    "msgtype":"text",
    "text":
    {
         "content":"Hello World"
    }
}
发送文本消息时，支持插入跳小程序的文字链

文本内容<a href="http://www.qq.com" data-miniprogram-appid="appid" data-miniprogram-path="pages/index/index">点击跳小程序</a>
说明：
1.data-miniprogram-appid 项，填写小程序appid，则表示该链接跳小程序；
2.data-miniprogram-path项，填写小程序路径，路径与app.json中保持一致，可带参数；
3.对于不支持data-miniprogram-appid 项的客户端版本，如果有herf项，则仍然保持跳href中的网页链接；
4.data-miniprogram-appid对应的小程序必须与公众号有绑定关系。

## 发送图片消息

{
    "touser":"OPENID",
    "msgtype":"image",
    "image":
    {
      "media_id":"MEDIA_ID"
    }
}

## 发送语音消息

{
    "touser":"OPENID",
    "msgtype":"voice",
    "voice":
    {
      "media_id":"MEDIA_ID"
    }
}

## 发送视频消息

{
    "touser":"OPENID",
    "msgtype":"video",
    "video":
    {
      "media_id":"MEDIA_ID",
      "thumb_media_id":"MEDIA_ID",
      "title":"TITLE",
      "description":"DESCRIPTION"
    }
}

## 发送音乐消息

{
    "touser":"OPENID",
    "msgtype":"music",
    "music":
    {
      "title":"MUSIC_TITLE",
      "description":"MUSIC_DESCRIPTION",
      "musicurl":"MUSIC_URL",
      "hqmusicurl":"HQ_MUSIC_URL",
      "thumb_media_id":"THUMB_MEDIA_ID" 
    }
}

## 发送图文消息（点击跳转到外链） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。

{
    "touser":"OPENID",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"Happy Day",
             "description":"Is Really A Happy Day",
             "url":"URL",
             "picurl":"PIC_URL"
         }
         ]
    }
}

## 发送图文消息（点击跳转到图文消息页面） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。

{
    "touser":"OPENID",
    "msgtype":"mpnews",
    "mpnews":
    {
         "media_id":"MEDIA_ID"
    }
}


## 发送菜单消息

{
  "touser": "OPENID"
  "msgtype": "msgmenu",
  "msgmenu": {
    "head_content": "您对本次服务是否满意呢? "
    "list": [
      {
        "id": "101",
        "content": "满意"
      },
      {
        "id": "102",
        "content": "不满意"
      }
    ],
    "tail_content": "欢迎再次光临"
  }
}

按照上述例子，用户会看到这样的菜单消息：

“您对本次服务是否满意呢？

满意

不满意”

其中，“满意”和“不满意”是可点击的，当用户点击后，微信会发送一条XML消息到开发者服务器，格式如下：

~~~
<xml>
<ToUserName><![CDATA[ToUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>1500000000</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[满意]]></Content>
<MsgId>1234567890123456</MsgId>
<bizmsgmenuid>101</bizmsgmenuid>
</xml>
~~~

XML参数说明：

|参数|说明|
|:--|:--|
|ToUserName|开发者帐号|
|FromUserName|接收方帐号（OpenID）|
|CreateTime|消息创建时间戳|
|MsgType|Text|
|Content|点击的菜单名|
|MsgId|消息ID|
|bizmsgmenuid|点击的菜单ID|
收到XML推送之后，开发者可以根据提取出来的bizmsgmenuid和Content识别出微信用户点击的是哪个菜单。



发送卡券

{
  "touser":"OPENID", 
  "msgtype":"wxcard",
  "wxcard":
  {              
   "card_id":"123dsdajkasd231jhksad"        
   }
}
特别注意客服消息接口投放卡券仅支持非自定义Code码和导入code模式的卡券的卡券，详情请见：是否自定义code码。

## 发送小程序卡片（要求小程序与公众号已关联）

接口调用示例：

{
    "touser":"OPENID",
    "msgtype":"miniprogrampage",
    "miniprogrampage":
    {
        "title":"title",
        "appid":"appid",
        "pagepath":"pagepath",
        "thumb_media_id":"thumb_media_id"
    }
}
请注意，如果需要以某个客服帐号来发消息（在微信6.0.2及以上版本中显示自定义头像），则需在JSON数据包的后半部分加入customservice参数，例如发送文本消息则改为：

{
    "touser":"OPENID",
    "msgtype":"text",
    "text":
    {
         "content":"Hello World"
    },
    "customservice":
    {
         "kf_account": "test1@kftest"
    }
}

|参数|是否必须|说明|
|:--|:--|:--|
|access_token|是|调用接口凭证|
|touser|是|普通用户openid|
|msgtype|是|消息类型，文本为text，图片为image，语音为voice，视频消息为video，音乐消息为music，图文消息（点击跳转到外链）为news，图文消息（点击跳转到图文消息页面）为mpnews，卡券为wxcard，小程序为miniprogrampage|
|content|是|文本消息内容|
|media_id|是|发送的图片/语音/视频/图文消息（点击跳转到图文消息页）的媒体ID|
|thumb_media_id|是|缩略图/小程序卡片图片的媒体ID，小程序卡片图片建议大小为520*416|
|title|否|图文消息/视频消息/音乐消息/小程序卡片的标题|
|description|否|图文消息/视频消息/音乐消息的描述|
|musicurl|是|音乐链接|
|hqmusicurl|是|高品质音乐链接，wifi环境优先使用该链接播放音乐|
|url|否|图文消息被点击后跳转的链接|
|picurl|否|图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80|
|appid|是|小程序的appid，要求小程序的appid需要与公众号有关联关系|
|pagepath|是|小程序的页面路径，跟app.json对齐，支持参数，比如pages/index/index?foo=bar|

## 客服输入状态
    开发者可通过调用“客服输入状态”接口，返回客服当前输入状态给用户。
    微信客户端效果图如下：
此接口需要客服消息接口权限。

如果不满足发送客服消息的触发条件，则无法下发输入状态。
下发输入状态，需要客服之前30秒内跟用户有过消息交互。
在输入状态中（持续15s），不可重复下发输入态。
在输入状态中，如果向用户下发消息，会同时取消输入状态。
接口调用请求说明

~~~
 http请求方式: POST https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN
JSON数据包如下：
 { "touser":"OPENID", "command":"Typing"}
~~~

预期返回：

~~~
 { "errcode":0, "errmsg":"ok"}
~~~

### 参数说明

|参数|是否必须|说明|
|:--|:--|:--|
|access_token|是|调用接口凭证|
|touser|是|普通用户（openid）|
|command|是|"Typing"：对用户下发“正在输入"状态 "CancelTyping"：取消对用户的”正在输入"状态|

## 返回码说明

|参数|说明|
|:--|:--|
|45072|command字段取值不对|
|45080|下发输入状态，需要之前30秒内跟用户有过消息交互|
|45081|已经在输入状态，不可重复下发|

## 获取客服连天记录
$json = $wechat->getCSMsgList($param);

$param参数示例

~~~
$param = [
  'starttime' => 987654321, //起始时间，unix时间戳
  'endtime' => 987654321, //结束时间，unix时间戳，每次查询时段不能超过24小时
  'msgid' => 1, //消息id顺序从小到大，从1开始
  'number' => 10000 //每次获取条数，最多10000条
];
~~~

响应数据示例

~~~
{
  "recordlist"   : [
     {
        "openid"   :  "oDF3iY9WMaswOPWjCIp_f3Bnpljk" ,
        "opercode"   : 2002,
        "text"   :  " 您好，客服test1为您服务。" ,
        "time"   : 1400563710,
        "worker"   :  "test1@test"
     },
     {
        "openid"   :  "oDF3iY9WMaswOPWjCIp_f3Bnpljk" ,
        "opercode"   : 2003,
        "text"   :  "你好，有什么事情？" ,
        "time"   : 1400563731,
        "worker"   :  "test1@test"
     }
  ],
  "number":2,
  "msgid":20165267
}
~~~