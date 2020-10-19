<?php

namespace TheIconicAPIDumper\Decorators;

use TheIconicAPIDumper\APIResponseInterface;

class VideoPreviewDecorator implements APIResponseInterface
{
    private $resultObject;
    private $APIWrapper;
    
    public function __construct($resultObject, $APIWrapper)
    {
        $this->resultObject = $resultObject;
        $this->APIWrapper = $APIWrapper;
    }
    
    public function getResultObject()
    {
        return $this->addVideoPreviewData($this->resultObject->getResultObject());
    }
    
    public function getContent()
    {
        return json_encode($this->getResultObject());
    }
    
    private function addVideoPreviewData($content)
    {
        if (empty($content)) {
            return $content;
        }
        
        $productList = $content->_embedded->product;
        foreach ($productList as $product) {
            if ($product->video_count > 0) {
                $videos = $this->APIWrapper->getVideosArray($product->sku);
                $product->_embedded->videos = $videos;
            }
        }
        
        return $content;
    }
}
