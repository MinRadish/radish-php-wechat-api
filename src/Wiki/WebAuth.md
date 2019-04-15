# 微信网页授权

~~~
    protected $scope = 'snsapi_base';// snsapi_base 静默授权(必须关注公众号) snsapi_userinfo 手动授权
~~~

## 获取跳转地址

~~~
    $url 授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
    $state 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
    $wechat->webAuthRedirect($url, $state); 

**  该方法返回跳转连接地址
~~~

    用户同意授权后

      如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。

    code说明 ： code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。

### 错误返回码说明如下：

    |返回码|说明|
    |:--|:--|
    |10003|redirect_uri域名与后台配置不一致|
    |10004|此公众号被封禁|
    |10005|此公众号并没有这些scope的权限|
    |10006|必须关注此测试号|
    |10009|操作太频繁了，请稍后重试|
    |10010|scope不能为空|
    |10011|redirect_uri不能为空|
    |10012|appid不能为空|
    |10013|state不能为空|
    |10015|公众号未授权第三方平台，请检查授权状态|
    |10016|不支持微信开放平台的Appid，请使用公众号Appid|

## 获取微信用户信息
~~~
    $code 微信回调地址带的参数
    $wechat->getUserInfo($code); 

**  该方法返回用户信息
~~~