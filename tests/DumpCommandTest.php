<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use TheIconicAPIDumper\DumpCommand;
use TheIconicAPIDumper\APIWrapper;

class DumpCommandTest extends TestCase
{
    const JSON_FIXTURE = 'tests/fixture/result.json';
    
    public function testItDumpsAJsonObject()
    {
        $fixtureData = file_get_contents(self::JSON_FIXTURE);
        $httpClientStub = new MockHttpClient(
            [new MockResponse($fixtureData)]
        );
             
        $APIWrapper = new APIWrapper($httpClientStub);
        $command = new DumpCommand($APIWrapper);
        $jsonResult = $command->dump();
        
        $this->assertJsonStringEqualsJsonFile(self::JSON_FIXTURE, $jsonResult);
    }
}