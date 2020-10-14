<?php

use PHPUnit\Framework\TestCase;
use TheIconicAPIDumper\DumpCommand;

class DumpCommandTest extends TestCase
{
    public function testItDumpsAJsonObject()
    {
        $command = new DumpCommand();
        $json = $command->dump();
        
        $this->assertJsonStringEqualsJsonFile('tests/fixture/result.json', $json);
    }
}