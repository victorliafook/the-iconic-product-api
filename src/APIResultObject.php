<?php

namespace TheIconicAPIDumper;

class APIResultObject implements APIResponseInterface
{
    private $resultObject;
    
    public function __construct($httpResponse)
    {
        $content = $httpResponse->getContent();
        $this->resultObject = json_decode($content);
    }
    
    public function getResultObject()
    {
        return $this->resultObject;
    }
    
    public function getContent()
    {
        return json_encode($this->getResultObject());
    }
}