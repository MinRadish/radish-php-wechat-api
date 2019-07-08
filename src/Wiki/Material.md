# 公众号上传素材

# 上传临时素材
~~~
$wechat->uploadMaterial($type, $media);
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