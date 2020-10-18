<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use TheIconicAPIDumper\APIWrapper;

class APIWrapperTest extends TestCase
{
    const TARGET_URL = APIWrapper::API_URL . '?gender=female&page=2&page_size=100&sort=popularity';
    
    public function testRequestBuilder()
    {
        $httpClientStub = new MockHttpClient(
            [new MockResponse('')]
        );
             
        $APIWrapperBuilder = APIWrapper::createBuilder($httpClientStub);
        $APIWrapperBuilder->gender('female')
            ->page('2')
            ->pageSize('100')
            ->sort('popularity');
            
        $APIWrapper = new APIWrapper($httpClientStub);
        $APIWrapper->setQuery($APIWrapperBuilder);
        
        $this->assertEquals($APIWrapper->getRequestURL(), self::TARGET_URL);
    }
}
