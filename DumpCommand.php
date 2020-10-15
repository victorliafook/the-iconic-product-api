<?php

namespace TheIconicAPIDumper;

class DumpCommand
{
    function __construct(APIWrapper $api)
    {
        $this->wrapper = $api;
    }
    
    public function dump()
    {
        $APIResponse = $this->wrapper->get();
        return $APIResponse;
    }
}