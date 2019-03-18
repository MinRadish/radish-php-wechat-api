# php对微信公众号的API的调用
<br/>
*需自定义一个类并继承 Radish\WeChat\WeChat 自定义CaChe抽象方法*
**public function cacheGet($key = 'access_token', $default = false);**
**public function cacheSet($key, $val, $timeout = 7140);**
## api示例说明
```
    $wechat = new WeChat();
```
### 获取客服列表
```
$json = $wechat->getCSList();
正确响应
{   
    "kf_list" : [
         {
            "kf_account" : "test1@test",
            "kf_headimgurl" : "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw/0",
            "kf_id" : "1001",
            "kf_nick" : "ntest1",
            "kf_wx" : "kfwx1"
         },
         {
            "kf_account" : "test2@test",
            "kf_headimgurl" : "http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw/0",
            "kf_id" : "1002",
            "kf_nick" : "ntest2",
            "kf_wx" : "kfwx2"
         }
    ]
}```
<br>
|参数|说明|
|:--|:--|
|kf_account|完整客服帐号，格式为：帐号前缀@公众号微信号|
|kf_nick|客服昵称|
|kf_id|客服编号|
|kf_headimgurl|客服头像|
|kf_wx|如果客服帐号已绑定了客服人员微信号， 则此处显示微信号|
|invite_wx|如果客服帐号尚未绑定微信号，但是已经发起了一个绑定邀请， 则此处显示绑定邀请的微信号|
|invite_expire_time|如果客服帐号尚未绑定微信号，但是已经发起过一个绑定邀请， 邀请的过期时间，为unix 时间戳|
|invite_status|邀请的状态，有等待确认“waiting”，被拒绝“rejected”， 过期“expired”|

<br>
### 获取在线客服列表
```
$json = $wechat->getOLCSList();
返回数据示例（正确时的JSON返回结果）：
 {
     "kf_online_list" : [
         {
             "kf_account" : "test1@test" ,
              "status" : 1,
              "kf_id" : "1001" ,
              "accepted_case" : 1
         },
         {
             "kf_account" : "test2@test" ,
              "status" : 1,
              "kf_id" : "1002" ,
              "accepted_case" : 2
         }
     ]
 }
参数说明

|参数|说明|
|:--|:--|
|kf_account|完整客服帐号，格式为：帐号前缀@公众号微信号|
|status|客服在线状态，目前为：1、web 在线|
|kf_id|客服编号|
|accepted_case|客服当前正在接待的会话数|
```
<br>
###添加客服帐号
```
$json = $wechat->addCS($param);
$param 示例
{
    "kf_account" : "test1@test",
    "nickname" : "客服1"
}

|:--参数|:--说明|
|:--|:--|
|kf_account|完整客服帐号，格式为：帐号前缀@公众号微信号，帐号前缀最多10个字符，必须是英文、数字字符或者下划线，后缀为公众号微信号，长度不超过30个字符|
|nickname|客服昵称，最长16个字|
返回数据示例（正确时的JSON返回结果）：
{
  "errcode" : 0,
  "errmsg" : "ok"
}
```

##客服管理接口返回码说明
```
|返回码|说明|
|:--|:--|
|0|成功|
|65400|API不可用，即没有开通/升级到新版客服功能|
|65401|无效客服帐号|
|65403|客服昵称不合法|
|65404|客服帐号不合法|
|65405|帐号数目已达到上限，不能继续添加|
|65406|已经存在的客服帐号|
|65407|邀请对象已经是该公众号客服|
|65408|本公众号已经有一个邀请给该微信|
|65409|无效的微信号|
|65410|邀请对象绑定公众号客服数达到上限（目前每个微信号可以绑定5个公众号客服帐号）|
|65411|该帐号已经有一个等待确认的邀请，不能重复邀请|
|65412|该帐号已经绑定微信号，不能进行邀请|
|40005|不支持的媒体类型|
|40009|媒体文件长度不合法|
```
