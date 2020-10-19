<?php

namespace TheIconicAPIDumper\Decorators;

use TheIconicAPIDumper\APIResponseInterface;

class VideoPreviewDecorator implements APIResponseInterface
{
    private $response;
    private $APIWrapper;
    
    public function __construct($httpResponse, $APIWrapper)
    {
        $this->response = $httpResponse;
        $this->APIWrapper = $APIWrapper;
    }
    
    public function getContent()
    {
        return $this->addVideoPreviewData($this->response->getContent());
    }
    
    private function addVideoPreviewData($content)
    {
        $resultObject = json_decode($content);
        
        if (empty($resultObject)) {
            return $content;
        }
        
        $productList = $resultObject->_embedded->product;
        foreach ($productList as $product) {
            if ($product->video_count > 0) {
                $videos = $this->APIWrapper->getVideosArray($product->sku);
                $product->_embedded->videos = $videos;
            }
        }
        
        return json_encode($resultObject);
    }
}
