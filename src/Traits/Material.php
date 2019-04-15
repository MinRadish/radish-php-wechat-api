<?php
namespace Radish\WeChat\Traits;

use Radish\Network\Curl;

/**
* @author Radish 1004622952@qq.com 2019-03-20
* 将微信公众号Api接口 添加素材
*/
trait Material
{
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