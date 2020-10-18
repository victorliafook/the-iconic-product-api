<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use TheIconicAPIDumper\APIWrapper;
use TheIconicAPIDumper\APIWrapperQueryBuilder;

class APIWrapperTest extends TestCase
{
    protected function setUp()
    {
        $this->APIQueryBuilder = APIWrapper::createQueryBuilder();
        $httpClientStub = new MockHttpClient(
            [new MockResponse('')]
        );
        $this->APIWrapper = new APIWrapper($httpClientStub);
    }
    
    private function getQueryForParam($param, $value)
    {
        $query = '?';
        $query .= APIWrapperQueryBuilder::PARAMETERS_KEYS[$param] . '=' . $value;
        return $query;
    }
    
    public function testRequestURLWithGenderParam()
    {
        $targetParamValue = str_shuffle('female');
        $targetURL = APIWrapper::API_URL . $this->getQueryForParam('gender',  $targetParamValue);
        
        $this->APIQueryBuilder->gender($targetParamValue);
        $this->APIWrapper->setQuery($this->APIQueryBuilder);
        
        $this->assertEquals($targetURL, $this->APIWrapper->getRequestURL());
    }
    
    public function testRequestURLWithPageParam()
    {
        $targetParamValue = str_shuffle('1234');
        $targetURL = APIWrapper::API_URL . $this->getQueryForParam('page',  $targetParamValue);

        $this->APIQueryBuilder->page($targetParamValue);
        $this->APIWrapper->setQuery($this->APIQueryBuilder);
        
        $this->assertEquals($targetURL, $this->APIWrapper->getRequestURL());
    }
    
    public function testRequestURLWithPageSizeParam()
    {
        $targetParamValue = str_shuffle('789');
        $targetURL = APIWrapper::API_URL . $this->getQueryForParam('pageSize',  $targetParamValue);
        
        $this->APIQueryBuilder->pageSize($targetParamValue);
        $this->APIWrapper->setQuery($this->APIQueryBuilder);
        
        $this->assertEquals($targetURL, $this->APIWrapper->getRequestURL());
    }
    
    public function testRequestURLWithSortParam()
    {
        $targetParamValue = str_shuffle('price');
        $targetURL = APIWrapper::API_URL . $this->getQueryForParam('sort',  $targetParamValue);
        
        $this->APIQueryBuilder->sort($targetParamValue);
        $this->APIWrapper->setQuery($this->APIQueryBuilder);
        
        $this->assertEquals($targetURL, $this->APIWrapper->getRequestURL());
    }
    
    public function testRequestURLWithAllParams()
    {
        $pageValue = '997';
        $pageSizeValue = '67';
        $genderValue = 'male';
        $sortValue = 'popularity';
        
        $queryParams = [];
        $queryParams[] = APIWrapperQueryBuilder::PARAMETERS_KEYS['page'] . '=' . $pageValue;
        $queryParams[] = APIWrapperQueryBuilder::PARAMETERS_KEYS['pageSize'] . '=' . $pageSizeValue;
        $queryParams[] = APIWrapperQueryBuilder::PARAMETERS_KEYS['gender'] . '=' . $genderValue;
        $queryParams[] = APIWrapperQueryBuilder::PARAMETERS_KEYS['sort'] . '=' . $sortValue;
        
        $query = '?' . implode($queryParams, '&');
        $targetURL = APIWrapper::API_URL . $query;
        
        $this->APIQueryBuilder->page($pageValue)
            ->pageSize($pageSizeValue)
            ->gender($genderValue)
            ->sort($sortValue);
        
        $this->APIWrapper->setQuery($this->APIQueryBuilder);
        
        $this->assertEquals($targetURL, $this->APIWrapper->getRequestURL());
    }
}
