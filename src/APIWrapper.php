<?php

namespace TheIconicAPIDumper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIWrapper
{
    const API_URL = 'https://eve.theiconic.com.au/catalog/products';
    private $query = '';
    
    function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public function get()
    {
        $requestURL = self::API_URL;
        if (!empty($this->query)) {
            $requestURL .= $this->query;
        }
        
        return $this->httpClient
            ->request('GET', $requestURL)
            ->getContent();
    }
    
    public function setQuery(APIWrapperQueryBuilder $queryBuilder)
    {
        $this->query = $queryBuilder->build();
    }
    
    public static function createQueryBuilder()
    {
        return new APIWrapperQueryBuilder();
    }
    
    public function getRequestURL()
    {
        return self::API_URL . $this->query;
    }
}
