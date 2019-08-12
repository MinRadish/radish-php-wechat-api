# 公众号上传素材

## 上传临时素材
~~~
$wechat->uploadMaterialTemp($type, $media);
响应:{"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
~~~
**$type**
~~~
|:值|:描述|
|image|图片资源|
|voice|语音|
|video|视频|
|thumb|缩略图| 
~~~
**$media**
~~~
$file = '文件绝对路径';
$param = [
  'media' => new \CURLFile($file)
]
~~~
## 上传永久素材
~~~
$wechat->uploadMaterialTemp($type, $media);
响应:{"media_id":"MEDIA_ID","url":URL}
~~~
**参数同获取临时素材**
