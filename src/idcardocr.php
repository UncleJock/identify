<?php

namespace bangmoo\idcardocr;

use RuntimeException;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Ocr\V20181119\OcrClient;
use TencentCloud\Ocr\V20181119\Models\IDCardOCRRequest;

class idcardocr
{

    private $client;
    protected $secretId = 'AKIDC9qEPKHXprMlcDpw0nKfmeGMefPxhG0T';
    protected $secretKey = 'LkwrWu2vfHdlcOt74YliPpc8NJL6bqnT';
    protected $region = 'ap-guangzhou';


    /**
     * 构造
     */
    private function __construct()
    {
        $cred = new Credential($this->secretId, $this->secretKey);
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint("ocr.tencentcloudapi.com");

        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        $this->client = new OcrClient($cred, $this->region, $clientProfile);
    }

    /**
     * 身份证识别
     * @param string $image_url
     * @return string
     * @author: chen
     * @time: 2020/7/3 9:36
     */
    public function cidcardocr($image_url = ''): string
    {
        try {
            $req = new IDCardOCRRequest();
            $params = "{\"ImageUrl\":\"" . $image_url . "\"}";
            $req->fromJsonString($params);
            $resp = $this->client->IDCardOCR($req);
            return $resp->toJsonString();
        } catch (RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

}
