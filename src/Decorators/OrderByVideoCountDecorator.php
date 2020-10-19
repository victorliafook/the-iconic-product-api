<?php

namespace TheIconicAPIDumper\Decorators;

use TheIconicAPIDumper\APIResponseInterface;

class OrderByVideoCountDecorator implements APIResponseInterface
{
    private $resultObject;
    
    public function __construct($resultObject)
    {
        $this->resultObject = $resultObject;
    }
    
    public function getResultObject()
    {
        return $this->orderProductsByVideoCount($this->resultObject->getResultObject());
    }
    
    public function getContent()
    {
        return json_encode($this->getResultObject());
    }
    
    private function orderProductsByVideoCount($content)
    {
        if (empty($content)) {
            return $content;
        }
        
        $productList = $content->_embedded->product;
        usort($productList, function ($p1, $p2) {
            return $p2->video_count - $p1->video_count;
        });
        
        $content->_embedded->product = $productList;
        return $content;
    }
}
