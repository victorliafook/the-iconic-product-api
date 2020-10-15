<?php

namespace TheIconicAPIDumper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIWrapper
{
    const API_URL = 'https://eve.theiconic.com.au/catalog/products';
    
    function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public function get()
    {
        return $this->httpClient
            ->request('GET', self::API_URL)
            ->getContent();
    }
}