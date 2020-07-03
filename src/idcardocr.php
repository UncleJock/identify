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

    /**
     * idcardocr constructor.
     * @param array $option
     */
    public function __construct(array $option = [])
    {
        $cred = new Credential($option['secretId'], $option['secretKey']);
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint("ocr.tencentcloudapi.com");

        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        $this->client = new OcrClient($cred, $option['region'], $clientProfile);
    }

    /**
     * 身份证识别
     * @param string $image_url
     * @param string $cardSide
     * @return string
     * @author: chen
     * @time: 2020/7/3 10:53
     */
    public function cidcardocr($image_url = '', $cardSide = ''): string
    {
        try {
            $req = new IDCardOCRRequest();
            $params = "{\"ImageUrl\":\"" . $image_url . "\",\"CardSide\":\"" . $cardSide . "\"}";
            $req->fromJsonString($params);
            $resp = $this->client->IDCardOCR($req);
            return $resp->toJsonString();
        } catch (RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

}
