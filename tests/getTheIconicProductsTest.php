// <?php 

// use PHPUnit\Framework\TestCase;
// use Symfony\Component\Console\Application;
// use Symfony\Component\Console\Tester\CommandTester;
// use Symfony\Component\HttpClient\MockHttpClient;
// use Symfony\Component\HttpClient\Response\MockResponse;
// use TheIconicAPIDumper\DumpCommand;
// use TheIconicAPIDumper\APIWrapper;

// class CreateUserCommandTest extends TestCase
// {
//     public function testExecute()
//     {
//         $httpClientStub = new MockHttpClient(
//             [new MockResponse('')]
//         );
             
//         $APIWrapper = new APIWrapper($httpClientStub);
        
//         $application = new Application();
//         $application -> add(new DumpCommand($APIWrapper));
        
//         $command = $application->find('app:create-user');
//         $commandTester = new CommandTester($command);
//         $commandTester->execute([
//             // pass arguments to the helper
//             'username' => 'Wouter',

//             // prefix the key with two dashes when passing options,
//             // e.g: '--some-option' => 'option_value',
//         ]);

//         // the output of the command in the console
//         $output = $commandTester->getDisplay();
//         $this->assertStringContainsString('Username: Wouter', $output);

//         // ...
//     }
// }