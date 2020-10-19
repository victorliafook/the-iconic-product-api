<?php

namespace TheIconicAPIDumper\Decorators;

use TheIconicAPIDumper\APIResponseInterface;

class OrderByVideoCountDecorator implements APIResponseInterface
{
    public function __construct($httpResponse)
    {
        $this->response = $httpResponse;
    }
    
    public function getContent()
    {
        return $this->orderProductsByVideoCount($this->response->getContent());
    }
    
    private function orderProductsByVideoCount($content)
    {
        $resultObject = json_decode($content);
        
        if (empty($resultObject)) {
            return $content;
        }
        
        $productList = $resultObject->_embedded->product;
        usort($productList, function ($p1, $p2) {
            return $p2->video_count - $p1->video_count;
        });
        
        $resultObject->_embedded->product = $productList;
        return json_encode($resultObject);
    }
}
