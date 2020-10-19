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
    const JSON_FIXTURE = 'tests/fixture/result.json';
    
    public function testItDumpsJSONFromHTTPRequest()
    {
        $fixtureData = file_get_contents(self::JSON_FIXTURE);
        $videoDetailsFixtureData = file_get_contents('tests/fixture/videoDetails.json');
        $videoAndOrderedDecoratedFixtureData = file_get_contents('tests/fixture/videoAndOrderedDecoratedResult.json');
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
        $mockResponseCallback = function($method, $url, $options) {
            $this->assertEquals(APIWrapper::API_URL . '?gender=male&page=1&page_size=10&sort=popularity', $url);

            return new MockResponse('...');
        };
        
        $httpClientStub = new MockHttpClient(
            [
                new MockResponse('...'),
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
            ->setMethods(['getArgument'])
            ->getMock();
        
        $getArgumentCallsMap = [
            ['gender', 'male'],
            ['page', '1'],
            ['page-size', '10'],
            ['sort', 'popularity'],
        ];
        
        $consoleInputMock->expects($this->any())
            ->method('getArgument')
            ->will($this->returnValueMap($getArgumentCallsMap));

        $command->execute($consoleInputMock, $consoleOutputMock);
     }
}
