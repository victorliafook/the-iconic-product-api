<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use TheIconicAPIDumper\DumpCommand;
use TheIconicAPIDumper\APIWrapper;

class DumpCommandTest extends TestCase
{
    const PRISTINE_JSON_RESULT_FIXTURE = 'tests/fixture/result.json';
    const VIDEO_DETAILS_JSON_RESULT_FIXTURE = 'tests/fixture/videoDetails.json';
    const VIDEO_ORDERED_JSON_RESULT_FIXTURE = 'tests/fixture/videoAndOrderedDecoratedResult.json';
    
    public function testItDumpsJSONFromHTTPRequest()
    {
        $fixtureData = file_get_contents(self::PRISTINE_JSON_RESULT_FIXTURE);
        $videoDetailsFixtureData = file_get_contents(self::VIDEO_DETAILS_JSON_RESULT_FIXTURE);
        $videoAndOrderedDecoratedFixtureData = file_get_contents(self::VIDEO_ORDERED_JSON_RESULT_FIXTURE);
        $httpClientStub = new MockHttpClient(
            [
                new MockResponse($fixtureData),
                new MockResponse($videoDetailsFixtureData)
            ]
        );
             
        $APIWrapper = new APIWrapper($httpClientStub);
        $command = new DumpCommand($APIWrapper);
        
        $consoleOutputMock = $this->getMockBuilder(ConsoleOutput::class)
            ->setMethods(['writeln'])
            ->getMock();
        
        $consoleOutputMock->expects($this->once())
            ->method('writeln')
            ->with(json_encode(json_decode($videoAndOrderedDecoratedFixtureData)));
        
        $consoleInputMock = $this->createMock(ArgvInput::class);
        $command->execute($consoleInputMock, $consoleOutputMock);
    }
    
    public function testCommandBuildsHttpQueryCorrectly()
    {
        $genderOption = 'male';
        $pageOption = '13';
        $pageSizeOption = '100';
        $sortOption = 'popularity';
        
        $query = "?gender=${genderOption}&page=${pageOption}&page_size=${pageSizeOption}&sort=${sortOption}";
        
        $mockResponseCallback = function ($method, $url, $options) use ($query) {
            $this->assertEquals(APIWrapper::API_URL . $query, $url);

            return new MockResponse('...');
        };
        
        $httpClientStub = new MockHttpClient(
            [
                $mockResponseCallback,
                new MockResponse('...')
            ]
        );
             
        $APIWrapper = new APIWrapper($httpClientStub);
        $command = new DumpCommand($APIWrapper);
        
        $consoleOutputMock = $this->getMockBuilder(ConsoleOutput::class)
            ->setMethods(['writeln'])
            ->getMock();
        
        $consoleOutputMock->expects($this->once())
            ->method('writeln');
        
        $consoleInputMock = $this->getMockBuilder(ArgvInput::class)
            ->setMethods(['getOption'])
            ->getMock();
        
        $getArgumentCallsMap = [
            ['gender', $genderOption],
            ['page', $pageOption],
            ['page-size', $pageSizeOption],
            ['sort', $sortOption],
        ];
        
        $consoleInputMock->expects($this->any())
            ->method('getOption')
            ->will($this->returnValueMap($getArgumentCallsMap));

        $command->execute($consoleInputMock, $consoleOutputMock);
    }
}
