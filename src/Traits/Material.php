<?php
namespace Radish\WeChat\Traits;

use Radish\Network\Curl;

/**
* @author Radish 1004622952@qq.com 2019-03-20
* 将微信公众号Api接口 添加素材
*/
trait Material
{
    /**
     * 上传临时素材
     * @param  string $type  媒体文件类型[图片(image), 语音(voice), 视频(video), 缩略图(thumb)]
     * @param  [type] $media [description]
     * @return [type]        [description]
     */
    public function uploadMaterial($type, $media)
    {
        $url = $this->getMaterialUrl('uploadMedia') . '&type=' . $type;
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];
        $result = Curl::post($url, $media, $options);
        
        return $this->getMessage($result, '上传失败！');
    }

    protected function getMaterialUrl($key)
    {
        $apiUrl = [
            'uploadMedia' => 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='
        ];

        return $apiUrl[$key] . $this->getAccessToken();
    }
}